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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->foreignId('column_id')->constrained()->onDelete('cascade'); // Coluna onde a task está
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Responsável pela task (opcional)

            $table->integer('position')->default(0); // Pra ordenar dentro da coluna
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
