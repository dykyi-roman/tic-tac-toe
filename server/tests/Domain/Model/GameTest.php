<?php

namespace Dykyi\Tests\Domain\Model;

use Dykyi\Domain\Model\Game;
use PHPUnit\Framework\TestCase;

/**
 * Class GameTest
 *
 * @coversDefaultClass \Dykyi\Domain\Model\Game
 *
 */
class GameTest extends TestCase
{
    /**
     * @covers ::getRobotUnit
     */
    public function testGetRobotUnit()
    {
        $robotUnit = 'O';
        $game = new Game('X', $robotUnit);

        $this->assertSame($game->getRobotUnit(), $robotUnit);
    }

    /**
     * @dataProvider boardDataProvider
     *
     * @covers ::makeMove
     */
    public function testGameMove($board, $result): void
    {
        $game = new Game('X', 'O');
        $move = $game->makeMove($board, 'X');

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
