<?php

namespace Dykyi\Test\Application;

use DG\BypassFinals;
use Dykyi\Domain\Service\GameServiceInterface;
use Dykyi\Domain\ValueObject\Board;
use Dykyi\Domain\ValueObject\Move;
use Dykyi\Infrastructure\DTO\MoveDTO;
use Dykyi\Infrastructure\Service\GameServiceService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GameServiceTest
 *
 * @coversDefaultClass \Dykyi\Infrastructure\Service\GameServiceService
 *
 */
class GameServiceTest extends TestCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        BypassFinals::enable();
    }

    /**
     * @covers ::move
     */
    public function testMakeMove(): void
    {
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->never())->method('dispatch');

        $board = $this->createMock(Board::class);
        $board->expects($this->never())->method('transform')->willReturn(['', '', '', '', '', '', '', '', '']);

        $gameService = $this->createMock(GameServiceInterface::class);
        $gameService->expects($this->once())->method('move')->willReturn(new MoveDTO(new Move(), 'O'));

        /** @var GameServiceService $gameService */
        $move = $gameService->move();
        $this->assertInstanceOf(MoveDTO::class, $move);
    }
}
