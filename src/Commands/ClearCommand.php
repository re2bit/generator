<?php

namespace Re2bit\Generator\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends AbstractCommand
{
    protected static $defaultName = 'generator:clear';

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $output->write(file_get_contents(__DIR__ . '/logo'));
        $output->writeln('clear Output');
        foreach ($this->adapters as $adapter => $outputPath) {
            $output->writeln('clear Output for "' . $adapter . '" : "' . $outputPath . '"');
            if (is_dir($outputPath)) {
                system('rm -rf ' . $outputPath . '/*');
            } else {
                $output->writeln('[ERROR] - "' . $outputPath . '" not found.');
            }
        }

        $output->writeln('done');
    }
}
