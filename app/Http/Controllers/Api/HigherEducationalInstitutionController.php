<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HigherEducationalInstitution;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HigherEducationalInstitutionController extends Controller
{
  use ApiResponser;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $locale = $request->user()->locale ?? 'uz';

    if ($request->has('locale'))
      if ($request->locale == 'uz_latn') $locale = 'uz';
      else $locale = $request->locale;

    $list = HigherEducationalInstitution::with([
      'region' => fn ($query) => $query->select("soato", "name_$locale as name")
    ])
      ->select([
        "id",
        "region_soato",
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
      'region_soato' => 'required',
    ]);

    if ($validator->fails()) {
      // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
      return response()->json($validator->errors(), 422);
    }

    $data = HigherEducationalInstitution::create([
      'title_uz' => $request->title_uz,
      'title_ru' => $request->title_ru,
      'description_uz' => $request->description_uz,
      'description_ru' => $request->description_ru,
      'region_soato' => $request->region_soato,
    ]);

    return $this->success($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\HigherEducationalInstitution  $higherEducationalInstitution
   * @return \Illuminate\Http\Response
   */
  public function show(HigherEducationalInstitution $higherEducationalInstitution)
  {
    return $this->success($higherEducationalInstitution);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\HigherEducationalInstitution  $higherEducationalInstitution
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, HigherEducationalInstitution $higherEducationalInstitution)
  {
    $validator = Validator::make($request->all(), [
      'title_uz' => 'required',
      'title_ru' => 'required',
      'region_soato' => 'required',
    ]);

    if ($validator->fails()) {
      // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
      return response()->json($validator->errors(), 422);
    }

    $higherEducationalInstitution->update([
      'title_uz' => $request->title_uz,
      'title_ru' => $request->title_ru,
      'description_uz' => $request->description_uz,
      'description_ru' => $request->description_ru,
      'region_soato' => $request->region_soato,
    ]);

    return $this->success($higherEducationalInstitution);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\HigherEducationalInstitution  $higherEducationalInstitution
   * @return \Illuminate\Http\Response
   */
  public function destroy(HigherEducationalInstitution $higherEducationalInstitution)
  {
    $higherEducationalInstitution->delete();
    return $this->success([], 'Success!');
  }

  public function fetchAll(Request $request)
  {
    $locale = $request->user()->locale ?? 'uz';

    if ($request->has('locale'))
      if ($request->locale == 'uz_latn') $locale = 'uz';
      else $locale = $request->locale;

    $list = HigherEducationalInstitution::select([
      "id",
      "title_$locale as title"
    ])
      ->get();

    return $this->success($list);
  }

  public function fetchDirections(Request $request, HigherEducationalInstitution $higherEducationalInstitution)
  {
    $locale = $request->user()->locale ?? 'uz';

    if ($request->has('locale'))
      if ($request->locale == 'uz_latn') $locale = 'uz';
      else $locale = $request->locale;

    $list = $higherEducationalInstitution->directions()
      ->select([
        'id',
        'higher_educational_institution_id',
        'subject_1',
        'subject_2',
        "title_$locale as title",
      ])
      ->get();

    return $this->success($list);

    // return $this->error('Not Found!', 404);
  }

  public function import()
  {
    Excel::import(new HigherEducationalInstitution(), 'users.xlsx');

    return redirect('/')->with('success', 'All good!');
  }
}
