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
        Schema::create('template_configurations', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('id_major')->nullable();
            $table->enum('type', ['uas', 'uts']);
            $table->string('template')->nullable();
            $table->unsignedInteger('id_school_year')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('template_configurations', function (Blueprint $table) {
            $table->foreign('id_major')->references('id')->on('majors')->onDelete('cascade');
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
        Schema::table('template_configurations', function (Blueprint $table) {
            $table->dropForeign('template_configurations_id_major_foreign');
            $table->dropForeign('template_configurations_id_school_year_foreign');
        });

        Schema::dropIfExists('template_configurations');
    }
};
