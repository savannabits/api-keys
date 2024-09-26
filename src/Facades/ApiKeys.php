<?php

namespace Savannabits\ApiKeys\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Savannabits\ApiKeys\ApiKeys
 */
class ApiKeys extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'api-keys';
    }
}
