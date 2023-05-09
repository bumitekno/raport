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
        Schema::create('attitude_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->enum('type', ['social', 'spiritual']);
            $table->unsignedBigInteger('id_student_class')->nullable();
            $table->unsignedInteger('id_school_year');
            $table->unsignedInteger('id_teacher');
            $table->string('predicate')->nullable();
            $table->json('attitudes');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('attitude_grades', function (Blueprint $table) {
            $table->foreign('id_student_class')->references('id')->on('student_classes')->onDelete('cascade');
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
        Schema::table('attitude_grades', function (Blueprint $table) {
            $table->dropForeign('attitude_grades_id_student_class_foreign');
            $table->dropForeign('attitude_grades_id_teacher_foreign');
            $table->dropForeign('attitude_grades_id_school_year_foreign');
        });
        Schema::dropIfExists('attitude_grades');
    }
};
