<?php

namespace App\Http\Controllers;

use App\Data;
use App\Exports\DataExport;
use App\Exports\DataRawExport;
use App\Http\Requests\DataRequest;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if (!session('student_no')) {
            return response()->redirectTo('/login');
        }

        return view('index');
    }

    public function data()
    {
        $guideList = [
            1 => [0, 1, 0],
            2 => [0, 2, 0],
            3 => [2, 1, 2],
            4 => [2, 1, 0],
            5 => [0, 1, 2],
        ];
        $goalList = [
            1 => [0, 1],
            2 => [1, 1],
            3 => [0, 2],
            4 => [1, 2],
            5 => [0, 3],
            6 => [1, 3],
            7 => [0, 4],
            8 => [1, 4],
        ];
        $correctMap = [
            1 => 2,
            2 => 1,
            3 => 1,
            4 => 2,
        ];

        $situations = [
            ['guideId' => 1, 'goalId' => 1],
            ['guideId' => 1, 'goalId' => 2],
            ['guideId' => 1, 'goalId' => 3],
            ['guideId' => 1, 'goalId' => 4],
            ['guideId' => 1, 'goalId' => 5],
            ['guideId' => 1, 'goalId' => 6],
            ['guideId' => 1, 'goalId' => 7],
            ['guideId' => 1, 'goalId' => 8],

            ['guideId' => 2, 'goalId' => 1],
            ['guideId' => 2, 'goalId' => 2],
            ['guideId' => 2, 'goalId' => 3],
            ['guideId' => 2, 'goalId' => 4],
            ['guideId' => 2, 'goalId' => 5],
            ['guideId' => 2, 'goalId' => 6],
            ['guideId' => 2, 'goalId' => 7],
            ['guideId' => 2, 'goalId' => 8],

            ['guideId' => 3, 'goalId' => 1],
            ['guideId' => 3, 'goalId' => 2],
            ['guideId' => 3, 'goalId' => 3],
            ['guideId' => 3, 'goalId' => 4],
            ['guideId' => 3, 'goalId' => 5],
            ['guideId' => 3, 'goalId' => 6],
            ['guideId' => 3, 'goalId' => 7],
            ['guideId' => 3, 'goalId' => 8],

            ['guideId' => 4, 'goalId' => 1],
            ['guideId' => 4, 'goalId' => 1],
            ['guideId' => 4, 'goalId' => 3],
            ['guideId' => 4, 'goalId' => 3],
            ['guideId' => 4, 'goalId' => 5],
            ['guideId' => 4, 'goalId' => 5],
            ['guideId' => 4, 'goalId' => 7],
            ['guideId' => 4, 'goalId' => 7],

            ['guideId' => 5, 'goalId' => 2],
            ['guideId' => 5, 'goalId' => 2],
            ['guideId' => 5, 'goalId' => 4],
            ['guideId' => 5, 'goalId' => 4],
            ['guideId' => 5, 'goalId' => 6],
            ['guideId' => 5, 'goalId' => 6],
            ['guideId' => 5, 'goalId' => 8],
            ['guideId' => 5, 'goalId' => 8],
        ];

        $roundList = [];
        for ($i=0; $i < 10; $i++) {
            $roundList[] = $situations;
        }
        $roundList = array_merge(...$roundList);
        shuffle($roundList);

        return [
            'guideList' => $guideList,
            'goalList' => $goalList,
            'correctMap' => $correctMap,
            'roundList' => $roundList,
        ];
    }

    public function submit(DataRequest $request)
    {
        $data = [
            'school' => session('school'),
            'class' => session('class'),
            'student_no' => session('student_no'),
            'ip' => $request->ip(),
            'data' => $request->input('data'),
        ];

        $result = Data::create($data);

        session(['last_id' => $result->id]);
    }

    public function lastResult()
    {
        $result = Data::where('id', session('last_id'))->first();

        if (!$result) return;

        return view('result', ['result' => $result]);
    }

    public function exportRaw($start = null, $end = null)
    {
        $end = $end ?? $start;

        $filter = [
            'start' => $start,
            'end' => $end,
        ];

        return (new DataRawExport($filter))->download('data_raw.xlsx');
    }

    public function export($start = null, $end = null)
    {
        $end = $end ?? $start;

        $filter = [
            'start' => $start,
            'end' => $end,
        ];

        return (new DataExport($filter))->download('data.xlsx');
    }
}