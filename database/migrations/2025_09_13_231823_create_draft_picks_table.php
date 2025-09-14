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
        Schema::create('draft_picks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draft_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('round');
            $table->integer('pick_number');
            $table->string('status')->default('pending');
            $table->timestamp('picked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_picks');
    }
};
