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
        Schema::create('retro_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retro_board_id')->constrained()->cascadeOnDelete();
            $table->enum('category', ['went_well', 'could_improve', 'action_item']);
            $table->text('content');
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retro_items');
    }
};
