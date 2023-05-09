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
        Schema::create('student_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_student')->nullable();
            $table->unsignedInteger('id_study_class');
            $table->year('year')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('student_classes', function (Blueprint $table) {
            $table->foreign('id_student')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_study_class')->references('id')->on('study_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_classes', function (Blueprint $table) {
            $table->dropForeign('student_classes_id_student_foreign');
            $table->dropForeign('student_classes_id_study_class_foreign');
        });

        Schema::dropIfExists('student_classes');
    }
};
