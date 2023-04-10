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
            $table->integer('id_major')->nullable();
            $table->enum('type', ['pas', 'pts']);
            $table->string('template')->nullable();
            $table->integer('id_school_year')->nullable();
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
        Schema::dropIfExists('template_configurations');
    }
};
