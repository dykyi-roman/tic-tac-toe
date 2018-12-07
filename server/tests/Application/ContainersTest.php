<?php

namespace Dykyi\Test\Application;

use Dykyi\Application\Containers;
use PHPUnit\Framework\TestCase;
use Stash\Interfaces\PoolInterface;

/**
 * Class ContainersTest
 *
 * @coversDefaultClass \Dykyi\Application\Containers
 *
 * @package Dykyi\Test\Application
 */
class ContainersTest extends TestCase
{
    /**
     * @covers ::init()
     * @covers ::get()
     */
    public function testInit()
    {
        $container = Containers::init();
        $this->assertInstanceOf(Containers::class, $container);

        $pool = $container->get(PoolInterface::class);
        $this->assertInstanceOf(PoolInterface::class , $pool);
    }
}