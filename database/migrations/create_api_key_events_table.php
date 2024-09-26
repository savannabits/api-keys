<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Savannabits\ApiKeys\Enums\ApiKeyEventType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('type', collect(ApiKeyEventType::cases())->map(fn($case) => $case->value)->toArray())->default(ApiKeyEventType::ACCESS);
            $table->foreignId('api_key_id')->constrained(Config::get('api-keys.tables.keys'))->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('action');
            $table->text('details')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName());
    }

    public function tableName(): string
    {
        return Config::get('api-keys.tables.events','api_key_events');
    }
};
