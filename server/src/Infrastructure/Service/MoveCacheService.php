<?php

namespace Dykyi\Infrastructure\Service;

use Stash\Interfaces\PoolInterface;

/**
 * Class MoveCacheService
 */
final class MoveCacheService
{
    /**
     * Variable
     *
     * @var PoolInterface |
     */
    private $pool;

    /**
     * GameCache constructor.
     *
     * @param PoolInterface $pool
     */
    public function __construct(PoolInterface $pool)
    {
        $this->pool = $pool;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function execute(string $key, $value)
    {
        $item = $this->pool->getItem($key);
        if ($item->isMiss()) {
            $item->set($value);
            $this->pool->save($item);
        }

        return $item->get() ?? $value;
    }
}
