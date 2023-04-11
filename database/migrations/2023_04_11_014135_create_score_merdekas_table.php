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
        Schema::create('score_merdekas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->bigInteger('id_student_class')->nullable();
            $table->integer('id_course')->nullable();
            $table->integer('id_study_class')->nullable();
            $table->integer('id_teacher')->nullable();
            $table->integer('id_school_year')->nullable();
            $table->json('score_formative')->nullable();
            $table->integer('average_formative')->nullable();
            $table->json('score_summative')->nullable();
            $table->integer('average_summative')->nullable();
            $table->integer('score_uts')->nullable();
            $table->integer('score_uas')->nullable();
            $table->integer('final_score')->nullable();
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
        Schema::dropIfExists('score_merdekas');
    }
};
