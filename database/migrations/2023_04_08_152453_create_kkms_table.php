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
        Schema::create('kkms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('id_study_class')->nullable();
            $table->unsignedInteger('id_course')->nullable();
            $table->integer('score')->nullable();
            $table->unsignedInteger('id_school_year')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('kkms', function (Blueprint $table) {
            $table->foreign('id_study_class')->references('id')->on('study_classes')->onDelete('cascade');
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::table('kkms', function (Blueprint $table) {
            $table->dropForeign('kkms_id_study_class_foreign');
            $table->dropForeign('kkms_id_course_foreign');
            $table->dropForeign('kkms_id_school_year_foreign');
        });

        Schema::dropIfExists('kkms');
    }
};
