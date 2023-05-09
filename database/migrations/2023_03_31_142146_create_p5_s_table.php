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
        Schema::create('p5_s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('title');
            $table->unsignedInteger('id_tema');
            $table->unsignedBigInteger('id_subject_teacher');
            $table->unsignedInteger('id_study_class');
            $table->text('description')->nullable();
            $table->json('sub_element')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('p5_s', function (Blueprint $table) {
            $table->foreign('id_tema')->references('id')->on('temas')->onDelete('cascade');
            $table->foreign('id_subject_teacher')->references('id')->on('subject_teachers')->onDelete('cascade');
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
        Schema::table('p5_s', function (Blueprint $table) {
            $table->dropForeign('p5_s_id_tema_foreign');
            $table->dropForeign('p5_s_id_subject_teacher_foreign');
            $table->dropForeign('p5_s_id_study_class_foreign');
        });

        Schema::dropIfExists('p5_s');
    }
};
