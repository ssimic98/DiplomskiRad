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
        Schema::create('adoption_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adoption_id');
            $table->string('question_text');
            $table->string('question_type');
            $table->json('options')->nullable();//Opcije za pitanja select
            $table->timestamps();

            $table->foreign('adoption_id')->references('id')->on('adoptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_questions');
    }
};
