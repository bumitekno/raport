<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('ALTER TABLE `study_classes` MODIFY `id_level` INTEGER NULL, MODIFY `id_major` INTEGER NULL;');
        DB::statement('ALTER TABLE `subject_teachers` MODIFY `id_teacher` INTEGER NULL, MODIFY `id_course` INTEGER NULL, MODIFY `id_school_year` INTEGER NULL, MODIFY `id_study_class` INTEGER NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nullable', function (Blueprint $table) {
            //
        });
    }
};
