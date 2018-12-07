<?php

namespace Dykyi\Infrastructure\Template;

/**
 * Interface TemplateInterface
 * @package Dykyi\Infrastructure\Template
 */
interface TemplateInterface
{
    /**
     * @param       $template
     * @param array $data
     *
     * @return string
     */
    public function render($template, array $data = []): string;

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function configuration(string $path);
}
