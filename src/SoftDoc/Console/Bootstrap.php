<?php
/**
 * Created by PhpStorm.
 * User: heiner
 * Date: 04.06.18
 * Time: 21:50
 */

namespace Hbaeumer\SoftDoc\Console;


use Hbaeumer\SoftDoc\Configuration;
use Hbaeumer\SoftDoc\Console\Command\RunCommand;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Bootstrap
{

    /**
     * @Inject
     * @var ContainerInterface
     */
    private $container;

    /**
     * @return Bootstrap
     */
    public static function createInstance()
    {
        return new self();
    }

    /**
     * @return Application
     */
    public function initialize()
    {
        $app = new Application();

        $app->getDefinition()->addOptions([
            new InputOption('config', '-c', InputOption::VALUE_REQUIRED, 'config file', getcwd().'/softdoc.json'),
        ]);
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
            $test = $event->getInput()->getOption('config');
            $event->getCommand()->getApplication()->setConfiguration(new Configuration($test));

        });
        $app->setDispatcher($dispatcher);
        $app->add($this->container->get(RunCommand::class));

        return $app;
    }

}