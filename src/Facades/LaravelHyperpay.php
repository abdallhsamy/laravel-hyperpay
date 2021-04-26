<?php

namespace Abdallhsamy\LaravelHyperpay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abdallhsamy\LaravelHyperpay\Skeleton\SkeletonClass
 */
class LaravelHyperpay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelHyperpay';
    }
}
