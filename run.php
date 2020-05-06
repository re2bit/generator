<?php

if (file_exists(__DIR__ . '/../../../vendor/autoload.php')) {
    include_once __DIR__ . '/../../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    include_once __DIR__ . '/vendor/autoload.php';
} else {
    throw new RuntimeException('Error: vendor/autoload.php could not be found.');
}

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;
use Re2bit\Generator\Commands\CreateCommand;
use \Re2bit\Generator\Commands\ClearCommand;
use Symfony\Component\Console\Application;
AnnotationRegistry::registerLoader('class_exists');

$application = new Application();
$application->addCommands([
    new CreateCommand(),
    new ClearCommand()
]);
$application->run();
