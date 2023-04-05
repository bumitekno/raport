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
            $table->tinyInteger('id_type_competence')->nullable();
            $table->integer('id_course');
            $table->integer('id_study_class');
            $table->integer('id_teacher');
            $table->integer('id_school_year');
            $table->string('code')->nullable();
            $table->string('achievement')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('competence_achievements');
    }
};
