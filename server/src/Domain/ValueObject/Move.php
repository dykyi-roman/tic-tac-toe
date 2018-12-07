<?php

namespace Dykyi\Domain\ValueObject;

/**
 * Class Move
 */
final class Move
{
    /**
     * Variable
     *
     * @var int |
     */
    private $index;
    /**
     * Variable
     *
     * @var int |
     */
    private $score;

    /**
     * Move constructor.
     *
     * @param int $score
     * @param int $index
     */
    public function __construct(int $score = 0, int $index = 0)
    {
        $this->index = $index;
        $this->score = $score;
    }

    /**
     * @param int $score
     * @param int $index
     *
     * @return Move
     */
    public static function create(int $score = 0, int $index = 0): Move
    {
        return new self($score, $index);
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }
}
