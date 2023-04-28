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
        Schema::create('covers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('footer')->nullable();
            $table->text('instruction')->nullable();
            $table->string('top_logo')->nullable();
            $table->string('middle_logo')->nullable();
            $table->integer('id_school_year');
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
        Schema::dropIfExists('covers');
    }
};
