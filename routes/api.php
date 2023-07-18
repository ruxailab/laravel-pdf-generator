<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
$data = [];
Route::get('/user/{id}', );

Route::post('/endpoint', function(Request $request){
  $test = json_decode($request->getContent(), true);
    $data = [
      'title' => isset($test["items"][0]["title"]) ? $test["items"][0]["title"] : '',
      'actualdate' => isset($test["items"][0]["date"]) ? $test["items"][0]["date"] : '', 
      'creationDate' => isset($test["items"][0]["creationDate"]) ? $test["items"][0]["creationDate"] : '', 
      'creatorEmail'=> isset($test["items"][0]["creatorEmail"]) ? $test["items"][0]["creatorEmail"] : '',
      'testDescription' => isset($test["items"][0]["testDescription"]) ? $test["items"][0]["testDescription"] : '',
      'finalReport' => isset($test["items"][0]["finalReport"]) ? $test["items"][0]["finalReport"] : '', 
      'testOptions' => isset($test["items"][0]["allOptions"]) ? $test["items"][0]["allOptions"] : '',
      'testAnswers' => isset($test["items"][0]["allAnswers"]) ? $test["items"][0]["allAnswers"] : '',
      'heuristics'=> isset($test["items"][0]["testStructure"]) ? $test["items"][0]["testStructure"] : '',
      'generalStatistics'=> isset($test["items"][0]["gstatistics"]) ? $test["items"][0]["gstatistics"] : '',
      'statisticsTable'=> isset($test["items"][0]["statisticstable"]) ? $test["items"][0]["statisticstable"] : '',

    ];
  
  $pdf = PDF::loadView('pdf.invoice', compact('data'));
  $pdf->render();
  $pdfStream = $pdf->output();

  return response($pdfStream, 200)
    ->header('Content-Type', 'application/pdf')
  ->header('Content-Disposition', 'attachment; filename="file.pdf"');

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
