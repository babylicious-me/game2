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
        Schema::create('two_truths_one_lie_questions', function (Blueprint $table) {
            $table->id();
            $table->text('statement_1');
            $table->boolean('is_truth_1');
            $table->text('statement_2');
            $table->boolean('is_truth_2');
            $table->text('statement_3');
            $table->boolean('is_truth_3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('two_truths_one_lie_questions');
    }
};
