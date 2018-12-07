<?php

namespace Dykyi\Domain\ValueObject;

use Dykyi\Domain\Exception\BoardDomainException;

/**
 * Class Board
 */
final class Board
{
    private const CELL_COUNT = 9;

    private const ERROR_FIELDS_COUNT = 'Fields Count must be 3';

    private const ERROR_CELL_COUNT = 'Cell Count must be 3';

    /**
     * Variable
     *
     * @var array |
     */
    private $board;

    /**
     * Board constructor.
     *
     * @param array $board
     *
     * @throws BoardDomainException
     */
    public function __construct(array $board = [])
    {
        $this->assertFieldCount($board);
        $this->board = $board;
    }

    /**
     * @return array
     */
    public function transform(): array
    {
        if (count($this->board) === self::CELL_COUNT) {
            return $this->board;
        }

        return $this->doTransform($this->board);
    }

    /**
     * @param array $board
     *
     * @return array
     */
    private function doTransform(array $board): array
    {
        $i = 0;
        $result = [];
        foreach ($board as $fields) {
            foreach ($fields as $cell) {
                $result[] = $cell === '' ? $i : $cell;
                $i++;
            }
        }

        return $result;
    }

    /**
     * @param array $board
     *
     * @throws BoardDomainException
     */
    private function assertFieldCount(array $board): void
    {
        if (count($board) !== 3) {
            throw new BoardDomainException(self::ERROR_FIELDS_COUNT);
        }

        foreach ($board as $field) {
            if (\is_array($field) && count($field) !== 3) {
                throw new BoardDomainException(self::ERROR_CELL_COUNT);
            }
        }
    }
}
