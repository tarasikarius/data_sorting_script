<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDataFileCommand extends Command
{
    protected function configure()
    {
        $this->setName('generate:data:file')
            ->setDescription('Generate file with filtered and sorted data')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Filter by name')
            ->addOption('url', null, InputOption::VALUE_REQUIRED, 'Valid url')
            ->addOption('stars', null, InputOption::VALUE_REQUIRED, 'Integer 0..5')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'File format to save data', 'json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $input->getOption('name');

    }
}
