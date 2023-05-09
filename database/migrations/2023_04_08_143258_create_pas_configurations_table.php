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
        Schema::create('pas_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->integer('average_daily_rate')->nullable();
            $table->integer('score_uts')->nullable();
            $table->integer('score_uas')->nullable();
            $table->unsignedInteger('id_school_year')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('pas_configurations', function (Blueprint $table) {
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
        Schema::table('pas_configurations', function (Blueprint $table) {
            $table->dropForeign('pas_configurations_id_school_year_foreign');
        });

        Schema::dropIfExists('pas_configurations');
    }
};
