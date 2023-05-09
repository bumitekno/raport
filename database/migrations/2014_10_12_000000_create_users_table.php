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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('name');
            $table->enum('gender', ['male', 'female']);
            $table->string('religion')->nullable();
            $table->string('file')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->enum('family_status', ['kandung', 'angkat']);
            $table->string('child_off')->nullable();
            $table->string('school_from')->nullable();
            $table->unsignedInteger('accepted_grade')->nullable();
            $table->date('accepted_date')->nullable();
            $table->string('password');
            $table->string('entry_year')->nullable();
            $table->dateTimeTz('last_login')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('accepted_grade')->references('id')->on('study_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_accepted_grade_foreign');
        });

        Schema::dropIfExists('users');
    }
};
