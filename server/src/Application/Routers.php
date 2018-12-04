<?php

namespace Dykyi\Application;

use Dykyi\Application\Controllers\TicTacToeController;

/**
 * Class Routers
 *
 * @package Dykyi\Infrastructure
 */
final class Routers
{
    public static function get(): array
    {
        return [
            ['GET', '/', [TicTacToeController::class, 'index']],
            ['POST', '/move', [TicTacToeController::class, 'move']],
        ];
    }
}