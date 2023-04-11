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
        Schema::create('assesment_weightings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->integer('id_teacher');
            $table->integer('id_course');
            $table->integer('id_study_class');
            $table->integer('id_school_year');
            $table->integer('formative_weight')->nullable();
            $table->integer('sumative_weight')->nullable();
            $table->integer('uts_weight')->nullable();
            $table->integer('uas_weight')->nullable();
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
        Schema::dropIfExists('assesment_weightings');
    }
};
