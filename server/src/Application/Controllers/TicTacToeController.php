<?php

namespace Dykyi\Application\Controllers;

use Dykyi\Application\Containers;
use Dykyi\Infrastructure\Template\TemplateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Tic Tac Toe API", version="0.1")
 *
 * Class TicTacToeController
 *
 * @package Dykyi\Infrastructure\Controllers
 */
class TicTacToeController
{
    /** @var mixed */
    private $engine;

    /**
     * DefaultController constructor.
     *
     * @param Containers $containers
     */
    public function __construct(Containers $containers)
    {
        $this->engine = $containers->get(TemplateInterface::class);
    }

    /**
     *
     * @return Response
     */
    public function index(): Response
    {
        $swagger = \OpenApi\scan(ROOT_DIR)->toYaml();
        file_put_contents('swagger.yaml', $swagger);

        return Response::create($this->engine->render('default/index', []));
    }

    /**
     * @OA\Post(
     *     path="/move",
     *     @OA\Response(response="200", description="Coordinate for the next move"),
     *     @OA\Parameter(
     *        name="boardState",
     *        in="query",
     *        required=true,
     *        description="Current board state",
     *        @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *        name="playerUnit",
     *        in="query",
     *        required=true,
     *        example="X",
     *        description="Player unit representation",
     *        @OA\Schema(type="string"),
     *     ),
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function move(Request $request): JsonResponse
    {
        $boardState = $request->get('boardState');
        $playerUnit = $request->get('playerUnit');

        return JsonResponse::create([
            'boardState' => $boardState,
            'playerUnit' => $playerUnit,
        ]);
    }
}
