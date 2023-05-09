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
        Schema::create('score_extracurriculars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('id_school_year')->nullable();
            $table->unsignedInteger('id_study_class')->nullable();
            $table->unsignedInteger('id_teacher')->nullable();
            $table->unsignedInteger('id_extra')->nullable();
            $table->json('score')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('score_extracurriculars', function (Blueprint $table) {
            $table->foreign('id_extra')->references('id')->on('extracurriculars')->onDelete('cascade');
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
        Schema::table('score_extracurriculars', function (Blueprint $table) {
            $table->dropForeign('score_extracurriculars_id_extra_foreign');
            $table->dropForeign('score_extracurriculars_id_study_class_foreign');
            $table->dropForeign('score_extracurriculars_id_teacher_foreign');
            $table->dropForeign('score_extracurriculars_id_school_year_foreign');
        });
        Schema::dropIfExists('score_extracurriculars');
    }
};
