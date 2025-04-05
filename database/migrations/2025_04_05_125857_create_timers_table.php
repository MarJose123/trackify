<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignUuid('clients_id')
                ->index()
                ->constrained('clients')
                ->cascadeOnDelete();
            $table->foreignUuid('projects_id')
                ->index()
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->bigInteger('duration');
            $table->string('status')->index();
            $table->json('timer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
