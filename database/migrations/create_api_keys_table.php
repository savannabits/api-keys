<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('key',255)->unique();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->unique(['name', 'deleted_at']);
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
        return Config::get('api-keys.tables.keys','api_keys');
    }
};
