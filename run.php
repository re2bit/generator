<?php

if (!is_dir(__DIR__ . '/vendor')) {
    echo 'Dependencies not found !' . PHP_EOL;
    echo 'Installing Dependencies:' . PHP_EOL;
    system('composer install');
}
if (!is_dir(__DIR__ . '/vendor')) {
    echo 'Error while Installation:' . PHP_EOL;
    die();
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
