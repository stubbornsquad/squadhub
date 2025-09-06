<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('steam_id')->unique();
            $table->string('discord_user_id')->unique();

            $table->string('avatar')->nullable();
            $table->json('previous_teams')->nullable();

            $table->string('first_game_role');
            $table->string('second_game_role');
            $table->string('third_game_role');

            $table->string('first_gameplay_style');
            $table->string('second_gameplay_style');

            $table->timestamp('joined_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
};
