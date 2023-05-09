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
        Schema::create('teachers', function (Blueprint $table) {

            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('nip')->nullable();
            $table->string('nik')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('religion')->nullable();
            $table->string('file')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->enum('type', ['homeroom', 'teacher', 'other']);
            $table->unsignedInteger('id_class')->nullable();
            $table->string('password');
            $table->dateTimeTz('last_login')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->foreign('id_class')->references('id')->on('study_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign('teachers_id_class_foreign');
        });

        Schema::dropIfExists('teachers');
    }
};
