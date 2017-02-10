<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Command\GenerateDataFileCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;

/* Create service container*/
$container = new ContainerBuilder();
$loader = new PhpFileLoader($container, new FileLocator(__DIR__));
$loader->load(__DIR__ . '/../config/services.php');

/* Create single command app*/
$application = new Application();
$command = new GenerateDataFileCommand($container);

$application->add($command);
$application->setDefaultCommand($command->getName(), true);

$application->run();
