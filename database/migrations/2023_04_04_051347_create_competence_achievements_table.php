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
        Schema::create('competence_achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedTinyInteger('id_type_competence')->nullable();
            $table->unsignedInteger('id_course');
            $table->unsignedInteger('id_study_class');
            $table->unsignedInteger('id_teacher');
            $table->unsignedInteger('id_school_year');
            $table->string('code')->nullable();
            $table->string('achievement')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('competence_achievements', function (Blueprint $table) {
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('id_study_class')->references('id')->on('study_classes')->onDelete('cascade');
            $table->foreign('id_teacher')->references('id')->on('teachers')->onDelete('cascade');
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
        Schema::table('competence_achievements', function (Blueprint $table) {
            $table->dropForeign('competence_achievements_id_course_foreign');
            $table->dropForeign('competence_achievements_id_study_class_foreign');
            $table->dropForeign('competence_achievements_id_teacher_foreign');
            $table->dropForeign('competence_achievements_id_school_year_foreign');
        });
        Schema::dropIfExists('competence_achievements');
    }
};
