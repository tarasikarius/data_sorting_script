<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\GenerateDataFileCommand;

$application = new Application();

$application->add(new GenerateDataFileCommand());

$application->run();
