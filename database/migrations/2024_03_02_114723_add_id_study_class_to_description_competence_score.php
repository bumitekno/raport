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
        Schema::table('description_competence_scores', function (Blueprint $table) {
            $table->unsignedInteger('id_study_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('description_competence_scores', function (Blueprint $table) {
            $table->dropColumn('id_study_class');
        });
    }
};
