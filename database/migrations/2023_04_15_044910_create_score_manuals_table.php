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
        Schema::create('score_manuals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->bigInteger('id_student_class')->nullable();
            $table->integer('id_teacher');
            $table->integer('id_course');
            $table->integer('id_study_class');
            $table->integer('id_school_year');
            $table->integer('assigment_grade')->nullable();
            $table->integer('daily_test_score')->nullable();
            $table->integer('score_uts')->nullable();
            $table->integer('score_uas')->nullable();
            $table->integer('score_final')->nullable();
            $table->string('predicate')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('score_manuals');
    }
};
