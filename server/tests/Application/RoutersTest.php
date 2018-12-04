<?php

namespace Dykyi\Test\Application;

use Dykyi\Application\Routers;
use PHPUnit\Framework\TestCase;

/**
 * Class RoutersTest
 *
 * @coversDefaultClass \Dykyi\Application\Routers
 *
 * @package Dykyi\Test\Application
 */
class RoutersTest extends TestCase
{
    /**
     * @covers ::get()
     */
    public function testBuildRoute()
    {
        $routers = Routers::get();
        $this->assertTrue(is_array($routers));


        foreach ($routers as $route){
            $this->assertContains($route[0], ['GET', 'POST', 'PUT', 'DELETE']);

            $this->assertTrue(class_exists($route[2][0]));
            $this->assertTrue(method_exists($route[2][0], $route[2][1]));
        }
    }
}