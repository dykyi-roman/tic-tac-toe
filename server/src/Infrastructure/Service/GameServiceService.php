<?php

namespace Dykyi\Infrastructure\Service;

use Dykyi\Domain\Event\MoveDomainEvent;
use Dykyi\Domain\MoveInterface;
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
     * Variable
     *
     * @var MoveInterface |
     */
    private $moveAction;

    /**
     * GameService constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param MoveInterface            $moveAction
     * @param Board                    $board
     * @param string                   $playerUnit
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        MoveInterface $moveAction,
        Board $board,
        string $playerUnit
    ) {
        $this->board = $board;
        $this->playerUnit = $playerUnit;
        $this->dispatcher = $dispatcher;
        $this->moveAction = $moveAction;
    }

    /**
     * {@inheritdoc}
     */
    public function move(): MoveDTO
    {
        $nextMove = $this->moveAction->makeMove($this->board->transform(), $this->playerUnit);
        $this->dispatcher->dispatch(MoveDomainEvent::MOVE_EVENT, new MoveDomainEvent($nextMove));

        return new MoveDTO($nextMove, $this->playerUnit);
    }
}
