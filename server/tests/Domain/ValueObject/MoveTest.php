<?php

namespace Dykyi\Tests\Domain\ValueObject;

use Dykyi\Domain\ValueObject\Move;
use PHPUnit\Framework\TestCase;

/**
 * Class MoveTest
 *
 * @coversDefaultClass \Dykyi\Domain\ValueObject\Move
 */
class MoveTest extends TestCase
{
    /**
     * @covers ::create
     */
    public function testCreateVOMove(): void
    {
        $move = new Move();

        $this->assertInstanceOf(Move::class, $move);
        $this->assertEquals($move, Move::create());
        $this->assertSame(0, $move->getScore());
        $this->assertSame(0, $move->getIndex());
    }

    /**
     * @covers ::create
     */
    public function testCreateVOMoveFailure(): void
    {
        $obj1 = new Move();
        $obj2 = Move::create();
        $this->assertTrue($obj1 !== $obj2);
    }

    /**
     * @covers ::getIndex
     */
    public function testGetterVOMove(): void
    {
        $score = 3;
        $index = 4;
        $move = new Move($score, $index);

        $this->assertSame($move->getIndex(), $index);
        $this->assertSame($move->getScore(), $score);
    }
}
