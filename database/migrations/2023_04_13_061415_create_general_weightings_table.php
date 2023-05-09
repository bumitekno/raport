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
        Schema::create('general_weightings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->enum('type', ['uts', 'uas']);
            $table->unsignedInteger('id_teacher');
            $table->unsignedInteger('id_course');
            $table->unsignedInteger('id_study_class');
            $table->unsignedInteger('id_school_year');
            $table->integer('score_weight')->nullable();
            $table->integer('uts_weight')->nullable();
            $table->integer('uas_weight')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('general_weightings', function (Blueprint $table) {
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
        Schema::table('general_weightings', function (Blueprint $table) {
            $table->dropForeign('general_weightings_id_teacher_foreign');
            $table->dropForeign('general_weightings_id_course_foreign');
            $table->dropForeign('general_weightings_id_study_class_foreign');
            $table->dropForeign('general_weightings_id_school_year_foreign');
        });

        Schema::dropIfExists('general_weightings');
    }
};
