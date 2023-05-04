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
        Schema::create('parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->string('nik')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('religion')->nullable();
            $table->enum('type', ['father', 'mother', 'guardian', 'other']);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('job')->nullable();
            $table->string('file')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('id_user');
            $table->dateTimeTz('last_login')->nullable();
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
        Schema::dropIfExists('parents');
    }
};
