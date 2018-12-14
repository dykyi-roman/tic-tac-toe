<?php

namespace Dykyi\Domain\Model;

use Dykyi\Domain\MoveInterface;
use Dykyi\Domain\ValueObject\Move;

/**
 * Class MoveAction
 */
final class MoveAction implements MoveInterface
{
    /** @var string */
    private $robot;

    /** @var string */
    private $human;

    /**
     * Game constructor.
     *
     * @param string $human
     * @param string $robot
     */
    public function __construct($human = 'X', $robot = 'O')
    {
        $this->human = $human;
        $this->robot = $robot;
    }

    /**
     * {@inheritdoc}
     */
    public function makeMove(array $newBoard, string $player = 'X'): Move
    {
        $availSpots = $this->getEmptyCell($newBoard);

        if ($this->isWinning($newBoard, $this->human)) {
            return Move::create(-10);
        }

        if ($this->isWinning($newBoard, $this->robot)) {
            return Move::create(10);
        }

        if (count($availSpots) === 0) {
            return Move::create(0);
        }

        $moves = $this->getMovesList($availSpots, $newBoard, $player);
        $bestMove = $this->getBestMoveCell($player, $moves);

        return $moves[$bestMove];
    }

    /**
     * Loop through available spots
     *
     * @param array  $availSpots
     * @param array  $newBoard
     * @param string $player
     *
     * @return array
     */
    private function getMovesList(array $availSpots, array $newBoard, string $player): array
    {
        $moves = [];
        foreach ($availSpots as $i => $iValue) {
            $index = $newBoard[$availSpots[$i]];

            // set the empty spot to the current player
            $newBoard[$availSpots[$i]] = $player;

            //if collect the score resulted from calling minimax on the opponent of the current player
            $result = $this->makeMove($newBoard, $player === $this->robot ? $this->human : $this->robot);
            $move = Move::create($result->getScore(), $index);

            //reset the spot to empty
            $newBoard[$availSpots[$i]] = $move->getIndex();

            $moves[] = $move;
        }

        return $moves;
    }

    /**
     * @param string $player
     * @param Move[] $moves
     *
     * @return int
     */
    private function getBestMoveCell(string $player, array $moves): int
    {
        return $player === $this->robot ? $this->getMinMove($moves) : $this->getMaxMove($moves);
    }

    /**
     * @param Move[] $moves
     *
     * @return int|string
     */
    private function getMinMove(array $moves)
    {
        $bestMove = 0;
        $bestScore = -10000;
        foreach ($moves as $i => $iValue) {
            if ($iValue->getScore() > $bestScore) {
                $bestScore = $iValue->getScore();
                $bestMove = $i;
            }
        }

        return $bestMove;
    }

    /**
     * @param Move[] $moves
     *
     * @return int|string
     */
    private function getMaxMove(array $moves)
    {
        $bestMove = 0;
        $bestScore = 10000;
        foreach ($moves as $i => $iValue) {
            if ($iValue->getScore() < $bestScore) {
                $bestScore = $iValue->getScore();
                $bestMove = $i;
            }
        }

        return $bestMove;
    }

    /**
     * @param array $board
     *
     * @return array
     */
    private function getEmptyCell(array $board): array
    {
        return array_values(array_filter($board, function ($cell) {
            return $cell !== 'O' && $cell !== 'X';
        }));
    }

    /**
     * Check winning combinations
     *
     * @param array  $board
     * @param string $player
     *
     * @return bool
     */
    private function isWinning(array $board, string $player): bool
    {
        return
            ($board[0] === $player && $board[1] === $player && $board[2] === $player) ||
            ($board[3] === $player && $board[4] === $player && $board[5] === $player) ||
            ($board[6] === $player && $board[7] === $player && $board[8] === $player) ||
            ($board[0] === $player && $board[3] === $player && $board[6] === $player) ||
            ($board[1] === $player && $board[4] === $player && $board[7] === $player) ||
            ($board[2] === $player && $board[5] === $player && $board[8] === $player) ||
            ($board[0] === $player && $board[4] === $player && $board[8] === $player) ||
            ($board[2] === $player && $board[4] === $player && $board[6] === $player);
    }
}
