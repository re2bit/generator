<?php

namespace Re2bit\Generator\Commands;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use DomainException;
use Re2bit\Generator\Adapter\GeneratorInterface;
use Re2bit\Generator\Twig\Renderer;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Re2bit\Generator\Model\Namensraum;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCommand extends AbstractCommand
{
    private const INPUT_OPTION_DATA_FILE = 'dataFile';
    private const INPUT_OPTION_DATA_FILE_SHORT = 'd';

    protected static $defaultName = 'generator:create';

    /** @var SerializerInterface  */
    private $serializer;
   /** @var RecursiveValidator|ValidatorInterface  */
    private $validator;

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
        $output->write(file_get_contents(__DIR__ . '/logo'));
        $output->writeln('');

        $dataFile = $input->getOption(self::INPUT_OPTION_DATA_FILE);

        $jsonString = null;
        if ($dataFile && !is_array($dataFile) && file_exists(realpath($dataFile))) {
            $jsonString = file_get_contents(realpath($dataFile));
        }

        if (!$dataFile || !$jsonString) {
            throw new \DomainException('Config File not Found');
        }

        /** @var Namensraum $namespace */
        $namespace = $this->serializer->deserialize($jsonString, Namensraum::class, 'json');
        $errors = $this->validator->validate($namespace);
        if (count($errors) >= 1)
        {
            throw new DomainException((string) $errors);
        }

        foreach ($namespace->modules as $module)
        {
            foreach ($this->adapters as $class => $outputDir)
            {
                /** @var GeneratorInterface $generator */
                $generator = new $class(
                    $module,
                    new Renderer(
                        $outputDir,
                        $class::TEMPLATES,
                        null,
                        $output
                    ),
                    null
                );
                $generator->generate();
            }
        }
        $output->writeln('Done');
        $output->write(file_get_contents(__DIR__ . '/foot'));
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
     * @return RecursiveValidator|ValidatorInterface
     * @throws AnnotationException
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
    private function createSerializer() : SerializerInterface
    {
        return SerializerBuilder::create()
            ->addDefaultDeserializationVisitors()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build();
    }
}
