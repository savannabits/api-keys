<?php

namespace Savannabits\ApiKeys\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Savannabits\ApiKeys\Facades\ApiKeys;

class ApiKey extends Model
{
    use SoftDeletes;

    /**
     * @throws \Throwable
     */
    public static function generate($name, $description = '', bool $active = true): ApiKey
    {
        $key = ApiKeys::generateKey($name);
        // Insert the key into the database
        $apiKey = new ApiKey();
        $apiKey->name = $name;
        $apiKey->description = $description;
        $apiKey->key = $key;
        $apiKey->active = true;
        $apiKey->saveOrFail();
        return $apiKey;
    }

    /**
     * @throws \Throwable
     */
    public function regenerate(): static
    {
        $this->key = ApiKeys::generateKey($this->name);
        $this->saveOrFail();
        return $this;
    }

    public static function getByKey($key, $onlyActive = true): static|null
    {
        $query = ApiKey::query()->where('key', $key);
        if ($onlyActive) {
            $query->where('active', true);
        }
        return $query->first();
    }

    public function logAccess(Request $request): void
    {
        $key = $this;
        \Log::info('API Key Access', [
            'key' => $key->name,
            'name' => $key->name,
            'description' => $key->description,
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
            'request' => $request->all(),
        ]);
    }
}
