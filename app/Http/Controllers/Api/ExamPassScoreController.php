<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExamPassScore;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamPassScoreController extends Controller
{
  use ApiResponser;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
      'hei_id' => 'required',
      'year' => 'required|max:' . date('Y'),
      'grant' => 'required',
      'contract' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $data = ExamPassScore::create([
      'hei_id' => $request->hei_id,
      'year' => $request->year,
      'grant' => $request->grant,
      'contract' => $request->contract,
      'direction_id' => $request->direction_id ?? null,
    ]);

    $one_year_earlier_data = ExamPassScore::where([
      ['hei_id', $request->hei_id],
      ['direction_id', $request->direction_id],
      ['year', $request->year - 1],
    ])->first();

    if ($one_year_earlier_data) {
      $old_grant = $one_year_earlier_data->grant ?? 0;
      $new_grant = $data->grant ?? 0;

      $status = $old_grant > $new_grant ? 'down' : ($old_grant < $new_grant ? 'up' : 'stable');

      $data->update(['status' => $status]);
    }

    return $this->success($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ExamPassScore  $examPassScore
   * @return \Illuminate\Http\Response
   */
  public function show(ExamPassScore $examPassScore)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ExamPassScore  $examPassScore
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ExamPassScore $examPassScore)
  {
    $validator = Validator::make($request->all(), [
      'hei_id' => 'required',
      'year' => 'required|max:' . date('Y'),
      'grant' => 'required',
      'contract' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $examPassScore->update([
      // 'hei_id' => $request->hei_id,
      // 'year' => $request->year,
      // 'direction_id' => $request->direction_id ?? null,
      'grant' => $request->grant,
      'contract' => $request->contract,
    ]);

    $one_year_earlier_data = ExamPassScore::where([
      ['hei_id', $examPassScore->hei_id],
      ['direction_id', $examPassScore->direction_id],
      ['year', $examPassScore->year - 1],
    ])->first();

    if ($one_year_earlier_data) {
      $old_grant = $one_year_earlier_data->grant ?? 0;
      $new_grant = $examPassScore->grant ?? 0;

      $status = $old_grant > $new_grant ? 'down' : ($old_grant < $new_grant ? 'up' : 'stable');

      $examPassScore->update(['status' => $status]);
    }

    return $this->success($examPassScore);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ExamPassScore  $examPassScore
   * @return \Illuminate\Http\Response
   */
  public function destroy(ExamPassScore $examPassScore)
  {
    //
  }
}
