<?php

namespace App\Providers;

use App\Models\Extracurricular;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View()->composer('layout.admin.v_sidebar_teacher', function ($view) {
            $mapelData = SubjectTeacher::with(['teacher', 'course' => function ($query) {
                $query->select(['id', 'name']);
            }])
                ->where('id_teacher', Auth::guard('teacher')->user()->id)
                ->where('id_school_year', session('id_school_year'))
                ->get(['id_course', 'id_study_class']);

            $studyClassIds = $mapelData->pluck('id_study_class')->flatMap(function ($item) {
                return json_decode($item);
            })->unique();

            $studyClassData = StudyClass::whereIn('id', $studyClassIds)
                ->select(['id', 'name'])
                ->get();

            $mapel = $mapelData->map(function ($item) {
                return [
                    'id_mapel' => $item->id_course,
                    'nama_mapel' => optional($item->course)->name,
                ];
            })->unique('id_mapel');

            $kelas = $mapelData->flatMap(function ($item) use ($studyClassData) {
                return collect(json_decode($item->id_study_class))->map(function ($id_kelas) use ($studyClassData) {
                    $kelas = $studyClassData->where('id', $id_kelas)->first();

                    return [
                        'id_kelas' => $kelas->id,
                        'nama_kelas' => $kelas->name,
                    ];
                });
            });

            $mapel = $mapel->map(function ($item) {
                return [
                    'id_mapel' => $item['id_mapel'],
                    'nama_mapel' => $item['nama_mapel'],
                ];
            })->pluck('nama_mapel', 'id_mapel');

            $kelas = $kelas->map(function ($item) {
                return [
                    'id_kelas' => $item['id_kelas'],
                    'nama_kelas' => $item['nama_kelas'],
                ];
            })->pluck('nama_kelas', 'id_kelas');
            $data = [
                'course' => $mapel,
                'study_class' => $kelas
            ];
            // dd($data);
            $view->with('class_course', $data);
        });

        View()->composer('layout.admin.v_sidebar_homeroom', function ($view) {
            $extra = Extracurricular::where('status', 1)->first();
            if (empty($extra)) {
                session()->put('message', 'Harap tambahkan minimal 1 ekstrakurikuler di admin');
                return view('pages.v_error');
            }
            $view->with(['side_extra' => $extra]);
        });

        JsonResource::withoutWrapping();
    }
}
