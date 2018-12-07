<?php

namespace Dykyi\Infrastructure\Service;

use Dykyi\Domain\Event\MoveDomainEvent;
use Dykyi\Domain\Model\Game;
use Dykyi\Domain\Service\GameServiceInterface;
use Dykyi\Domain\ValueObject\Board;
use Dykyi\Infrastructure\DTO\MoveDTO;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GameService
 */
final class GameServiceService implements GameServiceInterface
{
    /**
     * Variable
     *
     * @var array |
     */
    private $board;
    /**
     * Variable
     *
     * @var string |
     */
    private $playerUnit;
    /**
     * Variable
     *
     * @var EventDispatcherInterface |
     */
    private $dispatcher;

    /**
     * GameService constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param Board                    $board
     * @param string                   $playerUnit
     */
    public function __construct(EventDispatcherInterface $dispatcher, Board $board, string $playerUnit)
    {
        $this->board = $board->transform();
        $this->playerUnit = $playerUnit;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function move(): MoveDTO
    {
        $human = $this->playerUnit === 'X' ? 'O' : 'X';
        $game = new Game($human, $this->playerUnit);

        $nextMove = $game->makeMove($this->board, $this->playerUnit);
        $this->dispatcher->dispatch(MoveDomainEvent::MOVE_EVENT, new MoveDomainEvent($nextMove));

        return new MoveDTO($nextMove, $game->getRobotUnit());
    }
}
