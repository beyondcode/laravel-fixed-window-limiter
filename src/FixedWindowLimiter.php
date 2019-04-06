<?php

namespace BeyondCode\FixedWindowLimiter;

use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Redis;
use Illuminate\Redis\Connections\Connection;

class FixedWindowLimiter
{
    /** @var int */
    private $timeWindow;

    /** @var int */
    private $limit;

    public function __construct(CarbonInterval $timeWindow, int $limit)
    {
        $this->timeWindow = $timeWindow->totalSeconds;

        $this->limit = $limit;
    }

    public static function create(CarbonInterval $window, int $limit): self
    {
        return new static($window, $limit);
    }
    
    public function attempt(string $resource): bool
    {
        $key = $this->buildKey($resource);

        $hits = $this->getConnection()->incr($key);

        if ($hits === 1) {
            $this->getConnection()->expire($key, $this->timeWindow);
        }

        return $hits <= $this->limit;
    }

    public function getUsage(string $resource): int
    {
        $usage = (int)$this->getConnection()->get($this->buildKey($resource));

        return min($this->limit, $usage);
    }

    public function getRemaining(string $resource): int
    {
        $remaining = $this->limit - $this->getUsage($resource);

        return max(0, $remaining);
    }

    private function getConnection(): Connection
    {
        return Redis::connection(config('limiter.connection'));
    }

    private function buildKey(string $resource): string
    {
        return config('limiter.prefix') . $resource;
    }
}
