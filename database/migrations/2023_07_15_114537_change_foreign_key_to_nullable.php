<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `study_classes` MODIFY `id_level` bigint NULL, MODIFY `id_major` bigint NULL;');
        DB::statement('ALTER TABLE `subject_teachers` MODIFY `id_teacher` bigint NULL, MODIFY `id_course` bigint NULL, MODIFY `id_school_year` bigint NULL, MODIFY `id_study_class` bigint NULL;');
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