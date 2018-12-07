<?php

namespace Dykyi\Tests\Domain\ValueObject;

use Dykyi\Domain\ValueObject\Board;
use PHPUnit\Framework\TestCase;

/**
 * Class BoardTest
 *
 * @coversDefaultClass \Dykyi\Domain\ValueObject\Board
 */
class BoardTest extends TestCase
{
    /**
     * @dataProvider boardDataProvider
     *
     * @covers ::transform
     */
    public function testBoardTransform($board, $result): void
    {
        $board = new Board($board);

        $this->assertSame($board->transform(), $result);
    }

    public function boardDataProvider(): array
    {
        return [
            [
                [['', '', ''], ['', '', ''], ['', '', '']],
                [0, 1, 2, 3, 4, 5, 6, 7, 8],
            ],

            [
                [['X', '', 'O'], ['', '', ''], ['', '', '']],
                ['X', 1, 'O', 3, 4, 5, 6, 7, 8],
            ],
            [
                [['X', 'X', 'X'], ['O', '', ''], ['', '', '']],
                ['X', 'X', 'X', 'O', 4, 5, 6, 7, 8],
            ],
        ];
    }
}
