<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_kds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->integer('id_school_year')->nullable();
            $table->bigInteger('id_student_class')->nullable();
            $table->json('assessment_score')->nullable();
            $table->integer('averege_assesment')->nullable();
            $table->json('skill_score')->nullable();
            $table->integer('averege_skill')->nullable();
            $table->integer('score_uas')->nullable();
            $table->integer('score_uts')->nullable();
            $table->integer('final_assesment')->nullable();
            $table->integer('final_skill')->nullable();
            $table->integer('id_subject_teacher')->nullable();
            $table->integer('id_study_class')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_kds');
    }
};
