<?php

namespace Savannabits\ApiKeys;

use Illuminate\Support\Facades\Config;
use Random\RandomException;
use Savannabits\ApiKeys\Models\ApiKey;

class ApiKeys
{
    /**
     * @throws \Throwable
     * @throws RandomException
     */
    public function generateKey($name): string
    {
        return hash('sha256', uniqid(Config::get('api-keys.key_prefix',''), true) . $name  . random_bytes(128));
    }
}
