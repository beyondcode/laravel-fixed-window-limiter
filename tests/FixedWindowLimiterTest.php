<?php

namespace BeyondCode\FixedWindowLimiter\Tests;

use BeyondCode\FixedWindowLimiter\FixedWindowLimiter;
use BeyondCode\FixedWindowLimiter\FixedWindowLimiterServiceProvider;
use Carbon\CarbonInterval;
use Orchestra\Testbench\TestCase;
use Redis;

class FixedWindowLimiterTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        Redis::del('fixed-window-limiter-resource');
    }

    protected function getPackageProviders($app)
    {
        return [
            FixedWindowLimiterServiceProvider::class
        ];
    }

    /** @test */
    public function it_limits_the_number_of_attempts()
    {
        $limiter = FixedWindowLimiter::create(CarbonInterval::second(2), 2);

        $this->assertTrue($limiter->attempt('resource'));
        $this->assertTrue($limiter->attempt('resource'));
        $this->assertFalse($limiter->attempt('resource'));
        $this->assertFalse($limiter->attempt('resource'));

        sleep(2);

        $this->assertTrue($limiter->attempt('resource'));
    }

    /** @test */
    public function it_returns_the_usage_count()
    {
        $limiter = FixedWindowLimiter::create(CarbonInterval::minute(), 100);

        $limiter->attempt('resource');
        $limiter->attempt('resource');

        $this->assertSame(2, $limiter->getUsage('resource'));
    }

    /** @test */
    public function it_returns_the_remaining_attempts_count()
    {
        $limiter = FixedWindowLimiter::create(CarbonInterval::minute(), 100);

        $limiter->attempt('resource');
        $limiter->attempt('resource');

        $this->assertSame(98, $limiter->getRemaining('resource'));
    }

    /** @test */
    public function it_returns_the_remaining_attempts_count_when_the_limit_is_exceeded()
    {
        $limiter = FixedWindowLimiter::create(CarbonInterval::minute(), 5);

        foreach(range(1,10) as $i) {
            $limiter->attempt('resource');
        }

        $this->assertSame(0, $limiter->getRemaining('resource'));
    }

    /** @test */
    public function it_returns_the_maximum_usage_when_its_over_the_limit()
    {
        $limiter = FixedWindowLimiter::create(CarbonInterval::minute(), 5);

        foreach(range(1,10) as $i) {
            $limiter->attempt('resource');
        }

        $this->assertSame(5, $limiter->getUsage('resource'));
    }
}