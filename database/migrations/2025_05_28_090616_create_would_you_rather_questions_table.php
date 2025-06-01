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
        Schema::create('would_you_rather_questions', function (Blueprint $table) {
            $table->id();
            $table->string('option_a');
            $table->string('option_b');
            $table->unsignedInteger('votes_a')->default(0);
            $table->unsignedInteger('votes_b')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('would_you_rather_questions');
    }
};
