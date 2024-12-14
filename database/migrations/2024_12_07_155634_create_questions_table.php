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

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('quiz_id')->index();
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->string('question_text');
            $table->enum('question_type', ['single_choice', 'multiple_choice', 'short_answer']);
            $table->integer('points')->default(1);
            $table->string('image')->nullable();
        });

        Schema::create('question_choices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('question_id')->index();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->string('choice_text');
            $table->boolean('is_correct')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_choices');
        Schema::dropIfExists('questions');
    }
};
