<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SettingScore\PredicatedRequest;
use App\Models\PredicatedScore;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PredicatedScoreController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Pengaturan Nilai Predikat Rapor');
        $data = PredicatedScore::select('*')->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('setting_scores.predicated_scores.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('setting_scores.predicated_scores.delete', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.setting_scores.v_predicated_score');
    }

    public function create()
    {
        session()->put('title', 'Tambah Predikat Skor');
        return view('content.setting_scores.v_form_predicated_score');
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Predikat Skor');
        $predicated = PredicatedScore::where('slug', $slug)->firstOrFail();
        // dd($predicated);
        return view('content.setting_scores.v_form_predicated_score', compact('predicated'));
    }

    public function storeOrUpdate(PredicatedRequest $request, $id = null)
    {
        $validatedData = $request->validated();

        $score = $validatedData['score'];
        $minScore = min($score);
        $maxScore = max($score);

        $data = [
            'name' => $validatedData['name'],
            'score' => $minScore . '-' . $maxScore,
            'grade_weight' => $validatedData['grade_weight'],
            'description' => $validatedData['description'],
            'slug' => str_slug($validatedData['name']) . '-' . Helper::str_random(5),
        ];

        PredicatedScore::updateOrCreate(
            ['id' => $id],
            $data
        );

        Helper::toast('Berhasil mengupdate nilai predikat', 'success');

        return redirect()->route('setting_scores.predicated_scores.index');
    }

    public function destroy($slug)
    {
        PredicatedScore::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus predikat', 'success');
        return redirect()->route('setting_scores.predicated_scores.index');
    }
}
