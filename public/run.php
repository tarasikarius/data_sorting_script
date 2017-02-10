<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\GenerateDataFileCommand;

/* Create single command app*/
$application = new Application();
$command = new GenerateDataFileCommand();

$application->add($command);
$application->setDefaultCommand($command->getName(), true);

$application->run();
