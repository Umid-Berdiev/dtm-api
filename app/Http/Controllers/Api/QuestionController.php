<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->all();
        $ids = $request->ids ?? [];
        $locale = 'uz';

        if ($request->has('locale'))
            if ($request->locale == 'uz_latn') $locale = 'uz';
            else $locale = $request->locale;

        $list = Question::when(count($ids), function ($query, $ids) {
            $query->with('subject')->whereHas(
                'subject',
                fn ($query2) => $query2->whereIn('id', $ids)
            );
        })
            ->select([
                "id",
                "level",
                "title_$locale as title",
                "description_$locale as description"
            ])
            ->when($request->has('search') && !empty($request->search), function ($query) use ($request, $locale) {
                $query->where("title_$locale", 'LIKE', '%' . $request->search . '%');
            })
            ->paginate($request->pageSize ?? 10);

        return response()->json($list);
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
            'subject_id' => 'required',
            'title_uz' => 'required',
            'title_ru' => 'required',
            'image_uz' => 'image|nullable',
            'image_ru' => 'image|nullable',
            'variant_1_uz' => 'required',
            'variant_1_ru' => 'required',
            'variant_2_uz' => 'required',
            'variant_2_ru' => 'required',
            'variant_3_uz' => 'required',
            'variant_3_ru' => 'required',
            'variant_4_uz' => 'required',
            'variant_4_ru' => 'required',
            'correct_variant' => 'required',
        ]);

        if ($validator->fails()) {
            // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
            return response()->json($validator->errors(), 422);
        }

        $data = Question::create([
            'subject_id' => $request->subject_id,
            'level' => $request->level,
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
            'variant_1_uz' => $request->variant_1_uz,
            'variant_1_ru' => $request->variant_1_ru,
            'variant_2_uz' => $request->variant_2_uz,
            'variant_2_ru' => $request->variant_2_ru,
            'variant_3_uz' => $request->variant_3_uz,
            'variant_3_ru' => $request->variant_3_ru,
            'variant_4_uz' => $request->variant_4_uz,
            'variant_4_ru' => $request->variant_4_ru,
            'correct_variant' => $request->correct_variant,
        ]);

        if ($request->has('image_uz') && !is_null($request->image_uz)) {
            $file = $request->image_uz;
            $filename = 'question_uz_' . time() . '.' . $file->clientExtension();
            Storage::putFileAs('public/images/questions', $file, $filename);
            $data->image_url_uz = "images/questions/$filename";
        }

        if ($request->has('image_ru') && !is_null($request->image_ru)) {
            $file = $request->image_ru;
            $filename = 'question_ru_' . time() . '.' . $file->clientExtension();
            Storage::putFileAs('public/images/questions', $file, $filename);
            $data->image_url_ru = "images/questions/$filename";
        }

        $data->save();
        return $this->success($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return $this->success($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required',
            'title_uz' => 'required',
            'title_ru' => 'required',
            'image_uz' => 'image|nullable',
            'image_ru' => 'image|nullable',
            'variant_1_uz' => 'required',
            'variant_1_ru' => 'required',
            'variant_2_uz' => 'required',
            'variant_2_ru' => 'required',
            'variant_3_uz' => 'required',
            'variant_3_ru' => 'required',
            'variant_4_uz' => 'required',
            'variant_4_ru' => 'required',
            'correct_variant' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $question->update([
            'subject_id' => $request->subject_id,
            'level' => $request->level,
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
            'variant_1_uz' => $request->variant_1_uz,
            'variant_1_ru' => $request->variant_1_ru,
            'variant_2_uz' => $request->variant_2_uz,
            'variant_2_ru' => $request->variant_2_ru,
            'variant_3_uz' => $request->variant_3_uz,
            'variant_3_ru' => $request->variant_3_ru,
            'variant_4_uz' => $request->variant_4_uz,
            'variant_4_ru' => $request->variant_4_ru,
            'correct_variant' => $request->correct_variant,
        ]);

        if ($request->has('image_uz') && !is_null($request->image_uz)) {
            Storage::delete("public/$question->image_url_uz");
            $file = $request->image_uz;
            $filename = 'question_uz_' . time() . '.' . $file->clientExtension();
            Storage::putFileAs('public/images/questions', $file, $filename);
            $question->image_url_uz = "images/questions/$filename";
        }

        if ($request->has('image_ru') && !is_null($request->image_ru)) {
            Storage::delete("public/$question->image_url_ru");
            $file = $request->image_ru;
            $filename = 'question_ru_' . time() . '.' . $file->clientExtension();
            Storage::putFileAs('public/images/questions', $file, $filename);
            $question->image_url_ru = "images/questions/$filename";
        }

        $question->save();
        return $this->success($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if (!is_null($question->image_url_uz))
            Storage::delete("public/$question->image_url_uz");
        if (!is_null($question->image_url_ru))
            Storage::delete("public/$question->image_url_ru");

        $question->delete();

        return $this->success([], 'Success!');
    }
}
