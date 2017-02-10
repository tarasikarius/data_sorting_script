<?php

namespace App\Command;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

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
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Filter by name', 1)
            ->addOption('url', null, InputOption::VALUE_REQUIRED, 'Valid url')
            ->addOption('stars', null, InputOption::VALUE_REQUIRED, 'Integer 0..5')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'File format to save data', 'json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getServiceContainer();
        $dataGenerator = $container->get('data_generator');
        
        $filters = [
            'name' => $input->getOption('name'),
            'url' => $input->getOption('url'),
            'stars' => $input->getOption('stars'),
        ];

        $result = $dataGenerator->generateFile($filters, $input->getOption('format'));

        $output->writeln($result);

    }

    /**
     * TODO: придумать более подходящее место для инициализации контейнера
     */
    private function getServiceContainer()
    {
        $container = new ContainerBuilder();
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__));
        $loader->load('../../config/services.php');

        return $container;
    }
}
