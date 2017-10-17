<?php

namespace MBaldanza\Console;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Application
{
    private $environment;
    private $container;
    private $application;
    private $rootDir;

    public function __construct($environment = 'production')
    {
        $this->environment = $environment;

        $this->container = new ContainerBuilder();
        $this->application = new ConsoleApplication();

        $this->rootDir = getcwd();

        $this->loadConfig();
        $this->registerCommands();
    }

    public function run()
    {
        $this->application->run();
    }

    public function getCommand($commandName)
    {
        return $this->application->find($commandName);
    }

    private function loadConfig()
    {
        $loader = new YamlFileLoader($this->container, new FileLocator($this->rootDir . '/config'));

        $configFileName = 'production' === $this->environment ? 'config.yml' : sprintf('config_%s.yml', $this->environment);

        $loader->load($configFileName);
    }

    private function registerCommands()
    {
        $commandIds = $this->container->findTaggedServiceIds('console.command');
        foreach ($commandIds as $commandId => $command) {
            $this->application->add($this->container->get($commandId));
        }
    }
}
