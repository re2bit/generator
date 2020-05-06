<?php

namespace Re2bit\Generator\Commands;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    protected const DEFAULT_CONFIG = __DIR__ . '/../Config/config.php';

    private const INPUT_OPTION_CONFIG_FILE = 'configFile';
    private const INPUT_OPTION_CONFIG_FILE_SHORT = 'c';

    /** @var array */
    protected $adapters;

    /**
     * Config
     *
     * @return array
     */
    protected function createAdapterConfig(InputInterface $input) : array
    {
        $file = $input->getOption(self::INPUT_OPTION_CONFIG_FILE);

        if (!$file) {
            throw new DomainException('Config File not Found');
        }

        if ($file && file_exists(realpath($file))) {
            return include realpath($file);
        }

        throw new DomainException('Config File "' . $file . '" not Found');
    }

    /**
     * @inheritDoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->adapters = $this->createAdapterConfig($input);
    }

    protected function configure()
    {
        $option = new InputOption(
            self::INPUT_OPTION_CONFIG_FILE,
            self::INPUT_OPTION_CONFIG_FILE_SHORT,
            InputOption::VALUE_REQUIRED
        );
        $inputDefinition = new InputDefinition([
            $option
        ]);

        $this->setDefinition($inputDefinition);
    }
}
