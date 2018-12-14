<?php

namespace Dykyi\Infrastructure\DTO;

use Dykyi\Domain\ValueObject\Move;

/**
 * Class MoveDTO
 */
final class MoveDTO
{
    /**
     * Variable
     *
     * @var array |
     */
    private $response;

    /**
     * MoveDTO constructor.
     *
     * @param Move   $move
     * @param string $robotUnit
     */
    public function __construct(Move $move, string $robotUnit)
    {
        $this->response = $this->changeFormatToPoint($move);
        $this->response[] = $robotUnit;
    }

    /**
     * @param Move $move
     *
     * @return array
     */
    private function changeFormatToPoint(Move $move): array
    {
        $x = -1;
        $y = 0;
        foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8] as $item) {
            $x++;
            if ($item > 0 && $item % 3 === 0) {
                $y++;
                $x = 0;
            }
            if ($move->getIndex() === $item) {
                break;
            }
        }

        return [$x, $y];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'result' => $this->response,
            'error' => null,
        ];
    }
}
