<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RegionController extends Controller
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

    $list = Region::select([
      "id",
      "soato",
      "name_$locale as name",
      "admincenter_$locale as admincenter"
    ])
      ->get();

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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Region  $region
   * @return \Illuminate\Http\Response
   */
  public function show(Region $region)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Region  $region
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Region $region)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Region  $region
   * @return \Illuminate\Http\Response
   */
  public function destroy(Region $region)
  {
    //
  }
}
