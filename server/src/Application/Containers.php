<?php

namespace Dykyi\Application;

use Dotenv\Dotenv;
use Dykyi\Infrastructure\Template\MustacheTemplate;
use Dykyi\Infrastructure\Template\TemplateInterface;
use GuzzleHttp\Client as GuzzleClient;
use Interop\Container\ContainerInterface;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Stash\Interfaces\PoolInterface;
use Stash\Pool as Cache;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Whoops\Run as Whoops;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Containers
 *
 * @package Dykyi\Application
 */
final class Containers
{
    /**
     *
     * @var ServiceManager null
     */
    private $handles;

    public function __construct()
    {
        $this->handles = new ServiceManager(
            [
                'factories' => [
                    'Config' => function (): array {
                        $envConfig = (new Dotenv(__DIR__ . '/../../'))->load();

                        $keys = [];
                        foreach ($envConfig as $item) {
                            $elements = explode('=', $item);
                            $keys[$elements[0]] = $elements[1];
                        }
                        return $keys;
                    },

                    'Guzzle' => function () {
                        return new GuzzleClient();
                    },

                    PoolInterface::class => function () {
                        return new Cache(new \Stash\Driver\FileSystem());
                    },

                    Whoops::class => function () {
                        $whoops = new \Whoops\Run();
                        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                        $whoops->register();

                        return $whoops;
                    },

                    EventDispatcherInterface::class => function (): EventDispatcher {
                        return new EventDispatcher();
                    },


                    LoggerInterface::class => function (ContainerInterface $container) {
                        $config = $container->get('Config');

                        $logger = new Logger('app');
                        $logger->pushHandler(new StreamHandler(__DIR__ . $config['log_path'], Logger::DEBUG));
                        $logger->pushHandler(new FirePHPHandler());

                        return $logger;
                    },
                    TemplateInterface::class => function () {
                        $template = new MustacheTemplate();
                        $template->configuration(dirname(__DIR__) . '/Application/View');
                        return $template;
                    },
                ],
            ]
        );
    }

    /**
     * @return Containers
     */
    public static function init(): Containers
    {
        return new self();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->handles instanceof ServiceManager) {
            $this->handles = new self();
        }

        return $this->handles->get($name);
    }
}
