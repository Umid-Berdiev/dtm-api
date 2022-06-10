<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DirectionController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\ExamPassScoreController;
use App\Http\Controllers\Api\HigherEducationalInstitutionController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('confirm-password', [AuthController::class, 'confirmPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::get('regions', [RegionController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/locale', function (Request $request) {
    $locale = $request->locale;
    $request->user()->update(['locale' => $locale]);
    return response()->json(['message' => 'success', 'locale' => $locale]);
  });
  Route::get('heis/all', [HigherEducationalInstitutionController::class, 'fetchAll']);
  Route::get('heis/filter', [HigherEducationalInstitutionController::class, 'filterByYear']);
  Route::get('heis/{hei}/directions', [HigherEducationalInstitutionController::class, 'fetchDirections']);
  Route::get('subjects/all', [SubjectController::class, 'fetchAll']);
  Route::get('subjects/defaults', [SubjectController::class, 'fetchDefaults']);
  Route::get('questions/filtered', [SubjectController::class, 'fetchQuestionsBySelectedSubjects']);
  Route::get('exams/{exam}/timer', [ExamController::class, 'refreshTimer']);
  Route::put('exams/{exam}/end_time', [ExamController::class, 'updateEndTime']);
  Route::get('exams/{exam}/results', [ExamController::class, 'fetchResultsByExamId']);
  Route::get('education_forms', [HigherEducationalInstitutionController::class, 'fetchEduForms']);
  Route::get('education_languages', [HigherEducationalInstitutionController::class, 'fetchEduLanguages']);

  Route::apiResource('heis', HigherEducationalInstitutionController::class);
  Route::apiResource('directions', DirectionController::class);
  Route::apiResource('subjects', SubjectController::class);
  Route::apiResource('questions', QuestionController::class);
  Route::apiResource('results', ResultController::class);
  Route::apiResource('exam_pass_scores', ExamPassScoreController::class);
});
