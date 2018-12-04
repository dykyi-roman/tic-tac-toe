<?php

namespace Dykyi\Test\Application;

use Dykyi\Application\Containers;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

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

        $client = $container->get('Guzzle');
        $this->assertInstanceOf(Client::class , $client);
    }
}