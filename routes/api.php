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
Route::get('/user/{id}', );
// Route::post('/endpoint', ApiController::class);
Route::post('/endpoint', function(Request $request){

  $data = $request->all();
  $pdf = PDF::loadView('pdf.invoice', $data);
  return $pdf->download('invoice.pdf');
  // $data = $request->all();
  // $pdf = Pdf::loadView('pdf.invoice', $data);
  // return $pdf;
});
   //try number 1
  // $pdf = App::make('dompdf.wrapper');
  // $pdf->loadHTML('<h1>Test</h1>');
  // $pdf->render();
  // return $pdf->stream();

  //try number 2
  
  // $pdf = Pdf::loadView('myfile');
  // $pdf->render();
  // $pdf->stream('test.pdf');
  // // return $data;
  // // return $pdf->download('invoice.pdf');
  // return $pdf;

  //try number 3
  // $dompdf = new Dompdf();
  // $dompdf->loadHtml("<h1>teste</h1>" . $data);
  // $dompdf->render();
  // $dompdf->stream();
  // return $dompdf;

  //try number 4
  // return Pdf::loadFile(public_path().'/myfile.html')->save('/path-to/my_stored_file.pdf')->stream('download.pdf');

  //try number 5 - >blank pdf
  // $data = $request->all();
  // $pdf = Pdf::loadView('pdf.invoice', $data);
  // return $pdf->download('invoice.pdf');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
