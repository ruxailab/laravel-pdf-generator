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
// Route::post('/endpoint', ApiController::class);
Route::post('/endpoint', function(Request $request){
  $test = json_decode($request->getContent(), true);

  // print_r($test);
  $data = ['title'=>$test["items"][0]["name"], 'actualdate'=>$test["items"][0]["date"]];
  print_r($data);
  $pdf = PDF::loadView('pdf.invoice', compact('data'));
  $pdf->render();
  $pdfStream = $pdf->output();
  // return $pdf->download('invoice.pdf')
  return response($pdfStream, 200)
    ->header('Content-Type', 'application/pdf')
  ->header('Content-Disposition', 'attachment; filename="file.pdf"');
  // return $data["items"][0]["quantity"];
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
