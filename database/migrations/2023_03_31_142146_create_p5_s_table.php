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
            $table->integer('id_tema');
            $table->integer('id_teacher');
            $table->integer('id_study_class');
            $table->text('description')->nullable();
            $table->json('sub_element')->nullable();
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
        Schema::dropIfExists('p5_s');
    }
};
