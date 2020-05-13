<?php

namespace Re2bit\Generator\Commands;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use DomainException;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Re2bit\Generator\Adapter\GeneratorInterface;
use Re2bit\Generator\Model\Namensraum;
use Re2bit\Generator\Twig\Renderer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCommand extends AbstractCommand
{
    private const INPUT_OPTION_DATA_FILE = 'dataFile';
    private const INPUT_OPTION_DATA_FILE_SHORT = 'd';

    protected static $defaultName = 'generator:create';

    /** @var SerializerInterface */
    private $serializer;
    /** @var RecursiveValidator|ValidatorInterface */
    private $validator;

    /**
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $option = new InputOption(
            self::INPUT_OPTION_DATA_FILE,
            self::INPUT_OPTION_DATA_FILE_SHORT,
            InputOption::VALUE_REQUIRED
        );

        $inputDefinition = $this->getDefinition();
        $inputDefinition->addOption($option);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->write($this->getLogo());
        $output->writeln('');

        $dataFile = $input->getOption(self::INPUT_OPTION_DATA_FILE);

        $jsonString = null;
        if ($dataFile && is_string($dataFile) && file_exists((string)realpath($dataFile))) {
            $jsonString = file_get_contents((string) realpath($dataFile));
        }

        if (!$dataFile || !$jsonString) {
            throw new DomainException('Config File not Found');
        }

        /** @var Namensraum $namespace */
        $namespace = $this->serializer->deserialize($jsonString, Namensraum::class, 'json');
        $errors = $this->validator->validate($namespace);
        if (count($errors) >= 1) {
            if ($errors instanceof ConstraintViolationList) {
                throw new DomainException($errors->__toString());
            }
            throw new DomainException('Validation failed');
        }

        foreach ($namespace->modules as $module) {
            foreach ($this->adapters as $class => $outputDir) {
                /** @var GeneratorInterface $generator */
                $generator = new $class(
                    $module,
                    new Renderer(
                        $outputDir,
                        $output,
                        $class::TEMPLATES,
                        null
                    ),
                    null
                );
                $generator->generate();
            }
        }
        $output->writeln('Done');
        $output->write($this->getFooter());
        return 0;
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->serializer = $this->createSerializer();
        $this->validator = $this->createValidator();
        parent::initialize($input, $output);
    }

    /**
     * Validator Factory Method
     *
     * @throws AnnotationException
     * @return RecursiveValidator|ValidatorInterface
     */
    private function createValidator()
    {
        return Validation::createValidatorBuilder()->addLoader(
            new AnnotationLoader(
                new AnnotationReader()
            )
        )->getValidator();
    }

    /**
     * Serializer Factory Method
     *
     * @return SerializerInterface
     */
    private function createSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->addDefaultDeserializationVisitors()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build();
    }
}
