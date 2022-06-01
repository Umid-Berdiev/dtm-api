<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = 'ru';

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $data = Exam::with([
            // 'results',
            'hei' => fn ($query) => $query->select(['id', "title_$locale as title"]),
            'direction' => fn ($query) => $query->select(['id', "title_$locale as title"])
        ])
            ->select(['id', 'direction_id', 'hei_id', 'start_time', 'end_time'])
            ->has('results')
            ->where('user_id', 1)
            // ->withCount(['results' => function (Builder $query) {
            //     $query->whereHas('user_variant', 'correct_variant');
            // }])
            ->get();
        // $data = auth()->user()->exam_results;

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user_id ?? 1;
        $exam_id = $request->exam_id;
        $subject_id = $request->subject_id;
        $question_id = $request->question_id;
        $subject_slug = $request->subject_slug;
        $user_variant = $request->user_variant;
        $status = $request->status;
        $order_id = $request->order_id ?? null;

        Result::updateOrCreate(
            [
                'user_id' => $user_id,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'question_id' => $question_id,
                'subject_slug' => $subject_slug
            ],
            [
                'user_variant' => $user_variant,
                'status' => $status,
                'order_id' => $order_id
            ]
        );

        $data = Result::select([
            'exam_id',
            'subject_id',
            'question_id',
            'subject_slug',
            'user_variant'
        ])->where('exam_id', $exam_id)->get();

        return $this->success($data, 'Result saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
