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
        Schema::create('basic_competencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('id_course')->nullable();
            $table->unsignedInteger('id_level')->nullable();
            $table->json('name')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('basic_competencies', function (Blueprint $table) {
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('id_level')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('basic_competencies', function (Blueprint $table) {
            $table->dropForeign('basic_competencies_id_course_foreign');
            $table->dropForeign('basic_competencies_id_level_foreign');
        });
        Schema::dropIfExists('basic_competencies');
    }
};
