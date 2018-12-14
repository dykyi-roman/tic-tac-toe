<?php

namespace Dykyi\Tests\Domain\Model;

use Dykyi\Domain\Model\MoveAction;
use PHPUnit\Framework\TestCase;

/**
 * Class GameTest
 *
 * @coversDefaultClass \Dykyi\Domain\Model\MoveAction
 *
 */
class GameTest extends TestCase
{
    /**
     * @dataProvider boardDataProvider
     *
     * @covers ::makeMove
     */
    public function testGameMove($board, $result): void
    {
        $action = new MoveAction('X', 'O');
        $move = $action->makeMove($board, 'X');

        $this->assertSame($move->getIndex(), $result);
    }

    public function boardDataProvider(): array
    {
        return [
            [[0, 1, 2, 3, 4, 5, 6, 7, 8], 0],
            [['X', 'O', 'X', 3, 4, 5, 6, 7, 8], 3],
            [['X', 'O', 2, 3, 'X', 5, 6, 7, 8], 2],
            [['O', 1, 'X', 'X', 4, 5, 'X', 'O', 'O'], 4],
            [['O', 'X', 'X', 'X', 4, 5, 'X', 'O', 'O'], 4],
            [['X', 'O', 'X', 3, 'O', 5, 'X', 7, 'O'], 3],
        ];
    }
}
