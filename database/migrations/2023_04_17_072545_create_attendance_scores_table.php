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
        Schema::create('attendance_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_student_class')->nullable();
            $table->unsignedInteger('id_school_year');
            $table->tinyInteger('ill')->default(0);
            $table->tinyInteger('excused')->default(0);
            $table->tinyInteger('unexcused')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('attendance_scores', function (Blueprint $table) {
            $table->foreign('id_student_class')->references('id')->on('student_classes')->onDelete('cascade');
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
        Schema::table('attendance_scores', function (Blueprint $table) {
            $table->dropForeign('attendance_scores_id_student_class_foreign');
            $table->dropForeign('attendance_scores_id_school_year_foreign');
        });

        Schema::dropIfExists('attendance_scores');
    }
};
