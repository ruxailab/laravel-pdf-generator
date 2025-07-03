<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::post('/endpoint', function (Request $request) {
  $test = json_decode($request->getContent(), true);
  $data = [
    'title' => isset($test["items"][0]["title"]) ? $test["items"][0]["title"] : '',

    'actualdate' => isset($test["items"][0]["date"]) ? $test["items"][0]["date"] : '',

    'creationDate' => isset($test["items"][0]["creationDate"]) ? $test["items"][0]["creationDate"] : '',

    'creatorEmail' => isset($test["items"][0]["creatorEmail"]) ? $test["items"][0]["creatorEmail"] : '',

    'cooperatorsEmail' => isset($test["items"][0]["cooperatorsEmail"]) ? $test["items"][0]["cooperatorsEmail"] : [],

    'testDescription' => isset($test["items"][0]["testDescription"]) ? $test["items"][0]["testDescription"] : '',

    'finalReport' => isset($test["items"][0]["finalReport"]) ? $test["items"][0]["finalReport"] : '',

    'allOptions' => isset($test["items"][0]["allOptions"]) ? $test["items"][0]["allOptions"] : '',

    'allAnswers' => isset($test["items"][0]["allAnswers"]) ? $test["items"][0]["allAnswers"] : '',

    'heuristics' => isset($test["items"][0]["testStructure"]) ? $test["items"][0]["testStructure"] : '',

    'statistics' => isset($test["items"][0]["statistics"]) ? $test["items"][0]["statistics"] : '',

    'generalStatistics' => isset($test["items"][0]["gstatistics"]) ? $test["items"][0]["gstatistics"] : '',

    'statisticsTable' => isset($test["items"][0]["statisticstable"]) ? $test["items"][0]["statisticstable"] : '',

    'heuristicStatistics' => isset($test["items"][0]["heuristicStatistics"]) ? $test["items"][0]["heuristicStatistics"] : '',

    'testComments' => isset($test["items"][0]["testComments"]) ? $test["items"][0]["testComments"] : '',

    'selectedHeuristics' => isset($test["items"][0]["selectedHeuristics"]) ? $test["items"][0]["selectedHeuristics"] : '',

    'statisticsByEvaluatorAnswer' => isset($test["items"][0]["statisticsByEvaluatorAnswer"]) ? $test["items"][0]["statisticsByEvaluatorAnswer"] : '',
    
    'statisticsByHeuristics' => isset($test["items"][0]["statisticsByHeuristics"]) ? $test["items"][0]["statisticsByHeuristics"] : '',
  ];


  $pdfFilePath = Storage::makeDirectory('Temporary PDF');

  // Generate the default PDF
  $pdf = PDF::loadView('pdf.invoice', compact('data'));
  $pdf->save($pdfFilePath . 'default.pdf'); // Save the PDF to the specified path

  // Generate the landscape page PDF
  // $landscape_page = PDF::loadView('pdf.landscapePages.landscape_page', compact('data'));
  // $landscape_page->setPaper('A4', 'landscape');
  // $landscape_page->save($pdfFilePath . 'landscape_page.pdf'); // Save the PDF to the specified path

  $merge = new \Clegginabox\PDFMerger\PDFMerger;
  $merge->addPDF($pdfFilePath . 'default.pdf', 'all');
  // $merge->addPDF($pdfFilePath . 'landscape_page.pdf', 'all', 'L');
  $merge->merge('file', $pdfFilePath . 'merged.pdf', 'P');

  // Get the merged PDF content
  $pdfStream = file_get_contents($pdfFilePath . 'merged.pdf');

  // Clean up: Delete the temporary PDF files
  unlink($pdfFilePath . 'default.pdf');
  // unlink($pdfFilePath . 'landscape_page.pdf');
  unlink($pdfFilePath . 'merged.pdf');

  Storage::deleteDirectory('public/temp');

  return response($pdfStream, 200)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'attachment; filename="file.pdf"');
});
