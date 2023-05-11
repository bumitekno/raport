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
        Schema::create('score_manual2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_student_class')->nullable();
            $table->unsignedInteger('id_teacher');
            $table->unsignedInteger('id_course');
            $table->unsignedInteger('id_study_class');
            $table->unsignedInteger('id_school_year');
            $table->integer('kkm')->nullable();
            $table->integer('final_assegment')->nullable();
            $table->integer('final_skill')->nullable();
            $table->string('predicate_assegment')->nullable();
            $table->string('predicate_skill')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('score_manual2s', function (Blueprint $table) {
            $table->foreign('id_student_class')->references('id')->on('student_classes')->onDelete('cascade');
            $table->foreign('id_teacher')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('id_study_class')->references('id')->on('study_classes')->onDelete('cascade');
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
        Schema::table('score_manual2s', function (Blueprint $table) {
            $table->dropForeign('score_manual2s_id_student_class_foreign');
            $table->dropForeign('score_manual2s_id_teacher_foreign');
            $table->dropForeign('score_manual2s_id_course_foreign');
            $table->dropForeign('score_manual2s_id_study_class_foreign');
            $table->dropForeign('score_manual2s_id_school_year_foreign');
        });

        Schema::dropIfExists('score_manual2s');
    }
};
