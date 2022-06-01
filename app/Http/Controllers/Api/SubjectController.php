<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = 'uz';

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $list = Subject::select([
            "id",
            "title_$locale as title",
            "description_$locale as description"
        ])
            ->when($request->has('search') && !empty($request->search), function ($query) use ($request, $locale) {
                $query->where("title_$locale", 'LIKE', '%' . $request->search . '%');
            })
            ->latest('id')
            ->paginate($request->pageSize ?? 10);

        return $this->success($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_uz' => 'required',
            'title_ru' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Subject::create([
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
        ]);

        return $this->success($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return $this->success($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $validator = Validator::make($request->all(), [
            'title_uz' => 'required',
            'title_ru' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subject->update([
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
        ]);

        return $this->success($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return $this->success([], 'Success!');
    }

    public function fetchAll(Request $request)
    {
        $locale = 'uz';

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $list = Subject::select([
            "id",
            "title_$locale as title",
        ])
            ->get();

        return $this->success($list);
    }

    public function fetchDefaults(Request $request)
    {
        $locale = 'uz';

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $list = Subject::select([
            "id",
            "title_$locale as title",
        ])
            ->whereIn('id', [1, 2, 3])
            ->get();

        return $this->success($list);
    }

    public function fetchQuestionsBySelectedSubjects(Request $request)
    {
        $locale = 'uz';
        $subject_1 = $request->subject_1;
        $subject_2 = $request->subject_2;
        $exam_id = $request->exam_id;
        $selected_otm = $request->selected_otm;
        $selected_direction = $request->selected_direction;

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $subject1 = Subject::whereId($subject_1)->select(['id', "title_$locale as title"])->first();
        $subject2 = Subject::whereId($subject_2)->select(['id', "title_$locale as title"])->first();
        $onatili = Subject::whereId(1)->select(['id', "title_$locale as title"])->first();
        $matematika = Subject::whereId(2)->select(['id', "title_$locale as title"])->first();
        $uzb_tarixi = Subject::whereId(3)->select(['id', "title_$locale as title"])->first();

        $subject_1_easy_questions = Question::getRandomData($subject_1, $locale);
        // $subject_1_middle_questions = Question::getRandomData($subject_1, $locale, 'middle');
        $subject_1_hard_questions = Question::getRandomData($subject_1, $locale, 'hard');

        $subject_2_easy_questions = Question::getRandomData($subject_2, $locale);
        // $subject_2_middle_questions = Question::getRandomData($subject_2, $locale, 'middle');
        $subject_2_hard_questions = Question::getRandomData($subject_2, $locale, 'hard');

        $onatili_easy_questions = Question::getRandomData(1, $locale, 'easy', 5);
        // $onatili_middle_questions = Question::getRandomData('onatili', $locale, 'middle', 4);
        $onatili_hard_questions = Question::getRandomData(1, $locale, 'hard', 5);

        $matematika_easy_questions = Question::getRandomData(2, $locale, 'easy', 5);
        // $matematika_middle_questions = Question::getRandomData('matematika', $locale, 'middle', 4);
        $matematika_hard_questions = Question::getRandomData(2, $locale, 'hard', 5);

        $uz_tarix_easy_questions = Question::getRandomData(3, $locale, 'easy', 5);
        // $uz_tarix_middle_questions = Question::getRandomData('uzb_tarixi', $locale, 'middle', 4);
        $uz_tarix_hard_questions = Question::getRandomData(3, $locale, 'hard', 5);

        $exam = Exam::firstOrCreate(
            ['id' => $exam_id],
            [
                'user_id' => 1,
                'title_uz' => 'exam_uz' . time(),
                'title_ru' => 'exam_ru' . time(),
                'start_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'end_time' => Carbon::parse('3 hours')->format('Y-m-d H:i:s'),
                'hei_id' => $selected_otm,
                'direction_id' => $selected_direction,
            ]
        );

        return $this->success([
            'subject1' => [
                'id' => $subject1->id,
                'title' => $subject1->title,
                'slug' => 'subject1',
                'questions' => [...$subject_1_easy_questions, ...$subject_1_hard_questions]
            ],
            'subject2' => [
                'id' => $subject2->id,
                'title' => $subject2->title,
                'slug' => 'subject2',
                'questions' => [...$subject_2_easy_questions, ...$subject_2_hard_questions]
            ],
            'onatili' => [
                'id' => $onatili->id,
                'title' => $onatili->title,
                'slug' => 'onatili',
                'questions' => [...$onatili_easy_questions, ...$onatili_hard_questions]
            ],
            'matematika' => [
                'id' => $matematika->id,
                'title' => $matematika->title,
                'slug' => 'matematika',
                'questions' => [...$matematika_easy_questions, ...$matematika_hard_questions]
            ],
            'uzb_tarixi' => [
                'id' => $uzb_tarixi->id,
                'title' => $uzb_tarixi->title,
                'slug' => 'uzb_tarixi',
                'questions' => [...$uz_tarix_easy_questions, ...$uz_tarix_hard_questions]
            ],
            'exam' => $exam
            // 'exam' => $exam->select(['id', 'start_time', 'end_time'])
        ]);
    }
}
