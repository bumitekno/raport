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
        Schema::create('sub_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->unsignedInteger('id_dimension');
            $table->unsignedInteger('id_element')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('sub_elements', function (Blueprint $table) {
            $table->foreign('id_dimension')->references('id')->on('dimensions')->onDelete('cascade');
            $table->foreign('id_element')->references('id')->on('elements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_elements', function (Blueprint $table) {
            $table->dropForeign('sub_elements_id_dimension_foreign');
            $table->dropForeign('sub_elements_id_element_foreign');
        });

        Schema::dropIfExists('sub_elements');
    }
};
