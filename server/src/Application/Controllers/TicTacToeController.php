<?php

namespace Dykyi\Application\Controllers;

use Dykyi\Application\Containers;
use Dykyi\Domain\Model\MoveAction;
use Dykyi\Domain\ValueObject\Board;
use Dykyi\Infrastructure\Service\GameServiceService;
use Dykyi\Infrastructure\Service\MoveCacheService;
use Dykyi\Infrastructure\Template\TemplateInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Stash\Interfaces\PoolInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /** @var LoggerInterface */
    private $logger;

    /** @var PoolInterface */
    private $cache;

    /** @var mixed */
    private $dispatcher;

    /**
     * DefaultController constructor.
     *
     * @param Containers $containers
     */
    public function __construct(Containers $containers)
    {
        $this->engine = $containers->get(TemplateInterface::class);
        $this->logger = $containers->get(LoggerInterface::class);
        $this->cache = $containers->get(PoolInterface::class);
        $this->dispatcher = $containers->get(EventDispatcherInterface::class);
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
     *        description="Current board state (JSON format)",
     *        @OA\Schema(
     *            type="string",format="json", default={{"","",""},{"","",""},{"","",""}}
     *        ),
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
     * @todo (json_decode) - Hack for swagger. Because they not normal work with array in array. Rewrite in the feature.
     *
     * @return JsonResponse
     */
    //
    public function move(Request $request): JsonResponse
    {
        $boardState = $request->get('boardState');
        $boardState = \is_string($boardState) ? json_decode($boardState, true) : (array)$boardState;
        $playerUnit = (string)$request->get('playerUnit');

        try {
            $response = (new GameServiceService(
                $this->dispatcher,
                new MoveAction($playerUnit === 'X' ? 'O' : 'X', $playerUnit),
                new Board($boardState),
                $playerUnit
            ))->move();

            if ((bool)getenv('cache_mode')) {
                $cache = new MoveCacheService($this->cache);
                $cache->execute(md5(serialize($boardState) . $playerUnit), $response);
            }
        } catch (Exception $exception) {
            return JsonResponse::create([
                'result' => [],
                'error' => $exception->getMessage(),
            ]);
        }

        $this->logger->info('board', $boardState);
        $this->logger->info('move', (array)$response);

        return JsonResponse::create($response);
    }
}
