<?php

namespace Dykyi\Domain\Event;

use Dykyi\Domain\ValueObject\Move;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class MoveDomainEvent
 */
final class MoveDomainEvent extends Event
{
    public const MOVE_EVENT = 'make.move';

    /**
     * Variable
     *
     * @var Move |
     */
    private $move;

    /**
     * MoveEvent constructor.
     *
     * @param Move $move
     */
    public function __construct(Move $move)
    {
        $this->move = $move;
    }

    /**
     * @return Move
     */
    public function getMove(): Move
    {
        return $this->move;
    }
}
