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
        Schema::create('score_p5_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_student_class')->nullable();
            $table->unsignedInteger('id_school_year');
            $table->unsignedInteger('id_p5');
            $table->unsignedBigInteger('id_subject_teacher');
            $table->json('score');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('score_p5_s', function (Blueprint $table) {
            $table->foreign('id_student_class')->references('id')->on('student_classes')->onDelete('cascade');
            $table->foreign('id_p5')->references('id')->on('p5_s')->onDelete('cascade');
            $table->foreign('id_subject_teacher')->references('id')->on('subject_teachers')->onDelete('cascade');
            $table->foreign('id_school_year')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('score_p5_s', function (Blueprint $table) {
            $table->dropForeign('score_p5_s_id_student_class_foreign');
            $table->dropForeign('score_p5_s_id_p5_foreign');
            $table->dropForeign('score_p5_s_id_subject_teacher_foreign');
            $table->dropForeign('score_p5_s_id_school_year_foreign');
        });

        Schema::dropIfExists('score_p5_s');
    }
};
