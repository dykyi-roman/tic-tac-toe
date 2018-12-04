<?php

namespace Dykyi\Infrastructure\Template;

use Mustache_Engine;

/**
 * Class MustacheTemplate
 *
 * @package Dykyi\Infrastructure\Template
 */
final class MustacheTemplate implements TemplateInterface
{
    /**
     * @var Mustache_Engine
     */
    private $engine;

    public function __construct()
    {
        $this->engine = new Mustache_Engine();
    }

    public function configuration(string $path)
    {
        $loader = new \Mustache_Loader_FilesystemLoader($path, ['extension' => '.html']);
        $engine = new Mustache_Engine();
        $engine->setLoader($loader);
        $this->engine = $engine;
    }

    /**
     * @inheritdoc
     */
    public function render($template, array $data = []): string
    {
        return $this->engine->render($template, $data);
    }
}