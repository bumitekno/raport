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
        Schema::create('study_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('name');
            $table->unsignedInteger('id_major');
            $table->unsignedInteger('id_level');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('study_classes', function (Blueprint $table) {
            $table->foreign('id_level')->references('id')->on('levels')->onDelete('cascade');
            $table->foreign('id_major')->references('id')->on('majors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_classes', function (Blueprint $table) {
            $table->dropForeign('study_classes_id_level_foreign');
            $table->dropForeign('study_classes_id_major_foreign');
        });

        Schema::dropIfExists('study_classes');
    }
};
