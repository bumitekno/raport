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
            $table->unsignedInteger('id_school_year');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('covers', function (Blueprint $table) {
            $table->foreign('id_school_year')->references('id')->on('school_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('covers', function (Blueprint $table) {
            $table->dropForeign('covers_id_school_year_foreign');
        });

        Schema::dropIfExists('covers');
    }
};
