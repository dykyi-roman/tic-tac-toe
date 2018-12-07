<?php

namespace Dykyi\Test\Application;

use Dykyi\Infrastructure\Service\MoveCacheService;
use PHPUnit\Framework\TestCase;
use Stash\Interfaces\ItemInterface;
use Stash\Interfaces\PoolInterface;

/**
 * Class MoveCacheServiceTest
 *
 * @coversDefaultClass \Dykyi\Infrastructure\Service\MoveCacheService
 *
 */
class MoveCacheServiceTest extends TestCase
{
    /**
     * @covers ::execute
     */
    public function testGetFromCacheMove(): void
    {
        $value = [0, 2, 'O'];
        $item = $this->createMock(ItemInterface::class);
        $item->expects($this->once())->method('isMiss')->willReturn(true);
        $item->expects($this->once())->method('set');
        $item->expects($this->once())->method('get')->willReturn($value);

        $pool = $this->createMock(PoolInterface::class);
        $pool->expects($this->once())->method('getItem')->willReturn($item);
        $pool->expects($this->once())->method('save');

        $move = new MoveCacheService($pool);
        $move = $move->execute('test_key', $value);

        $this->assertArraySubset($move, $value);
    }

    /**
     * @covers ::execute
     */
    public function testGetNotFromCacheMove(): void
    {
        $value = [0, 2, 'O'];
        $item = $this->createMock(ItemInterface::class);
        $item->expects($this->once())->method('isMiss')->willReturn(false);
        $item->expects($this->never())->method('set');
        $item->expects($this->once())->method('get')->willReturn($value);

        $pool = $this->createMock(PoolInterface::class);
        $pool->expects($this->once())->method('getItem')->willReturn($item);
        $pool->expects($this->never())->method('save');

        $move = new MoveCacheService($pool);
        $move = $move->execute('test_key', $value);

        $this->assertArraySubset($move, $value);
    }
}
