<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EducationForm;
use App\Models\EducationLanguage;
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
    $locale = $request->user()->locale;

    // if ($request->has('locale'))
    //   if ($request->locale == 'uz_latn') $locale = 'uz';
    //   else $locale = $request->locale;

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
      ->orderBy("title_$locale")
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

    if (count($request->edu_forms)) $data->education_forms()->attach($request->edu_forms);
    if (count($request->edu_langs)) $data->education_languages()->attach($request->edu_langs);


    return $this->success($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\HigherEducationalInstitution  $hei
   * @return \Illuminate\Http\Response
   */
  public function show(HigherEducationalInstitution $hei)
  {
    $locale = auth()->user()->locale ?? 'uz';
    $data = $hei->load([
      'education_forms',
      'education_languages',
      'directions',
      'ratings'
    ]);
    $data["title"] = $data["title_$locale"];

    return $this->success($data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\HigherEducationalInstitution  $hei
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, HigherEducationalInstitution $hei)
  {
    // return $request->all();
    $validator = Validator::make($request->all(), [
      'title_uz' => 'required',
      'title_ru' => 'required',
      'region_soato' => 'required',
    ]);

    if ($validator->fails()) {
      // return $this->error('Validation errors', 422, ['messages' => $validator->errors()]);
      return response()->json($validator->errors(), 422);
    }

    $hei->update([
      'title_uz' => $request->title_uz,
      'title_ru' => $request->title_ru,
      'description_uz' => $request->description_uz,
      'description_ru' => $request->description_ru,
      'region_soato' => $request->region_soato,
    ]);

    $edu_forms = json_decode($request->edu_forms);
    $edu_langs = json_decode($request->edu_langs);
    $hei->education_forms()->sync($edu_forms);
    $hei->education_languages()->sync($edu_langs);

    return $this->success($hei);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\HigherEducationalInstitution  $hei
   * @return \Illuminate\Http\Response
   */
  public function destroy(HigherEducationalInstitution $hei)
  {
    $hei->delete();
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

  public function fetchDirections(Request $request, HigherEducationalInstitution $hei)
  {
    $locale = $request->user()->locale ?? 'uz';

    // if ($request->has('locale'))
    //   if ($request->locale == 'uz_latn') $locale = 'uz';
    //   else $locale = $request->locale;

    $list = $hei->directions()
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

  public function fetchExamPassScores(Request $request, HigherEducationalInstitution $hei)
  {
    $locale = $request->user()->locale ?? 'uz';

    $list = $hei->exam_pass_scores()
      ->with([
        'direction' => fn ($query) => $query->select([
          "id",
          "title_$locale as title"
        ])
      ])
      ->latest('year')
      ->get();

    return $this->success($list);

    // return $this->error('Not Found!', 404);
  }

  public function import()
  {
    Excel::import(new HigherEducationalInstitution(), 'users.xlsx');

    return redirect('/')->with('success', 'All good!');
  }

  public function fetchEduForms(Request $request)
  {
    $locale = auth()->user()->locale;
    $data = EducationForm::select(['id', "title_$locale as title"])->get();

    return $this->success($data);
  }

  public function fetchEduLanguages(Request $request)
  {
    $locale = auth()->user()->locale;
    $data = EducationLanguage::select(['id', "name_$locale as name"])->get();

    return $this->success($data);
  }

  public function filterByYear(Request $request)
  {
    $locale = $request->user()->locale ?? 'uz';
    $year = $request->year ?? date('Y') - 1;

    $list = HigherEducationalInstitution::with([
      // 'ratings'
      'exam_pass_scores' => fn ($query) => $query->where("year", $year)
    ])
      // ->whereHas('ratings', fn ($query) => $query->where("year", $year))
      ->select([
        "id",
        "title_$locale as title",
      ])
      ->orderBy("title_$locale")
      ->paginate($request->pageSize ?? 10);

    return $this->success($list);
  }

  public function filter(Request $request)
  {
    $locale = $request->user()->locale ?? 'uz';
    $year = (int) $request->year ?? date('Y') - 1;

    $list = HigherEducationalInstitution::with([
      'region',
      'exam_pass_scores',
      'education_forms' => fn ($query) => $request->edu_form_id && $query->whereId($request->edu_form_id),
      'education_languages' => fn ($query) => $request->edu_lang_id && $query->whereId($request->edu_lang_id)
    ])
      ->select([
        "id",
        "title_$locale as title",
      ])
      ->when(
        $request->has('region_soato') && !empty($request->region_soato),
        function ($query) use ($request) {
          $query->whereHas("region", fn ($query2) => $query2->where('soato', $request->region_soato));
        }
      )
      ->when(
        $request->has('edu_form') && !empty($request->edu_form),
        function ($query) use ($request) {
          $query->whereHas("education_forms", fn ($query2) => $query2->where('education_forms.id', $request->edu_form));
        }
      )
      ->when(
        $request->has('edu_lang') && !empty($request->edu_lang),
        function ($query) use ($request) {
          $query->whereHas("education_languages", fn ($query2) => $query2->where('education_languages.id', $request->edu_lang));
        }
      )
      ->withCount('directions')
      ->withSum([
        'exam_pass_scores as total_quota' => fn ($query) => $query->where('year', $year)
      ], 'quota')
      ->whereHas(
        "exam_pass_scores",
        fn ($query) => $query->where('year', $year)
      )
      ->orderBy("title_$locale")
      ->paginate($request->pageSize ?? 10);
    // $list = 'success';
    return $this->success($list);
  }
}
