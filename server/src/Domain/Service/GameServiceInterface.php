<?php

namespace Dykyi\Domain\Service;

use Dykyi\Infrastructure\DTO\MoveDTO;

/**
 * Interface GameInterface
 * @package Dykyi\Domain\Service
 */
interface GameServiceInterface
{
    /**
     * @return MoveDTO
     */
    public function move(): MoveDTO;
}
