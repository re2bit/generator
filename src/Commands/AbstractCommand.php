<?php /** @noinspection ALL */

namespace Re2bit\Generator\Commands;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    private const INPUT_OPTION_CONFIG_FILE = 'configFile';
    private const INPUT_OPTION_CONFIG_FILE_SHORT = 'c';

    /** @var array<string,string> */
    protected array $adapters;

    /**
     * Config
     *
     * @param InputInterface $input
     *
     * @return array<string,string>
     */
    protected function createAdapterConfig(InputInterface $input): array
    {
        $file = $input->getOption(self::INPUT_OPTION_CONFIG_FILE);

        if (!is_string($file)) {
            throw new DomainException('Config File not Found');
        }

        if (!file_exists((string)realpath($file))) {
            throw new DomainException('Config File "' . $file . '" not Found');
        }

        return include realpath($file);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->adapters = $this->createAdapterConfig($input);
    }

    protected function configure(): void
    {
        $option = new InputOption(
            self::INPUT_OPTION_CONFIG_FILE,
            self::INPUT_OPTION_CONFIG_FILE_SHORT,
            InputOption::VALUE_REQUIRED
        );
        $inputDefinition = new InputDefinition([
            $option,
        ]);

        $this->setDefinition($inputDefinition);
    }

    protected function getLogo(): string
    {
        return file_get_contents(__DIR__ . '/logo') ?: '';
    }

    protected function getFooter(): string
    {
        return file_get_contents(__DIR__ . '/foot') ?: '';
    }
}
