<?php

namespace Abdallhsamy\LaravelHyperpay\Tests;

use Abdallhsamy\LaravelHyperpay\LaravelHyperpayServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelHyperpayServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
