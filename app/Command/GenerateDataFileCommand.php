<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GenerateDataFileCommand extends Command
{
    private $container;
    
    public function __construct(ContainerBuilder $container, $name = null)
    {
        $this->container = $container;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('generate:data:file')
            ->setDescription('Generate file with filtered and sorted data')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Filter by name', 1)
            ->addOption('url', null, InputOption::VALUE_REQUIRED, 'Valid url')
            ->addOption('stars', null, InputOption::VALUE_REQUIRED, 'Integer 0..5')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'File format to save data', 'json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataGenerator = $this->container->get('data_generator');

        $filters = [
            'name' => $input->getOption('name'),
            'url' => $input->getOption('url'),
            'stars' => $input->getOption('stars'),
        ];

        $result = $dataGenerator->generateFile($filters, $input->getOption('format'));

        $output->writeln($result);

    }
}
