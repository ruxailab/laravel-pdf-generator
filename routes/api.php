<?php
 use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
      'aut' => isset($test["items"][0]["aut"]) ? $test["items"][0]["aut"] : '',
    ];
  print_r($data);
  
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
