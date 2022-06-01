<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectionController extends Controller
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

        $list = Direction::with([
            'higher_educational_institution' => fn ($query) => $query->select("id", "title_$locale as title")
        ])
            ->select([
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
            'subject_1' => 'required',
            'subject_2' => 'required',
            'otm_id' => 'required',

        ]);

        if ($validator->fails()) {
            // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
            return response()->json($validator->errors(), 422);
        }

        $data = Direction::create([
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
            'subject_1' => $request->subject_1,
            'subject_2' => $request->subject_2,
            'higher_educational_institution_id' => $request->otm_id,
        ]);

        return $this->success($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Direction  $direction
     * @return \Illuminate\Http\Response
     */
    public function show(Direction $direction)
    {
        return $this->success($direction);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Direction  $direction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Direction $direction)
    {
        $validator = Validator::make($request->all(), [
            'title_uz' => 'required',
            'title_ru' => 'required',
            'subject_1' => 'required',
            'subject_2' => 'required',
            'otm_id' => 'required',

        ]);

        if ($validator->fails()) {
            // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
            return response()->json($validator->errors(), 422);
        }

        $data = $direction->update([
            'title_uz' => $request->title_uz,
            'title_ru' => $request->title_ru,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
            'subject_1' => $request->subject_1,
            'subject_2' => $request->subject_2,
            'higher_educational_institution_id' => $request->otm_id,
        ]);

        return $this->success($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Direction  $direction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Direction $direction)
    {
        $direction->delete();
        return $this->success([], 'Success!');
    }
}
