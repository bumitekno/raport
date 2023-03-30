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
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->date('report_date');
            $table->date('final_report_date');
            $table->date('pts_date');
            $table->date('last_pts_date');
            $table->string('headmaster');
            $table->string('nip_headmaster');
            $table->string('signature')->nullable();
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
        Schema::dropIfExists('configs');
    }
};
