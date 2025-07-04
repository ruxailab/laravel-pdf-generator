<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

Route::post('/endpoint', function (Request $request) {
  $test = json_decode($request->getContent(), true);
  $item = $test["items"][0] ?? [];

  $data = [
    'title' => $item["title"] ?? '',
    'creationDate' => $item["creationDate"] ?? '',
    'creatorEmail' => $item["creatorEmail"] ?? '',
    'cooperatorsEmail' => $item["cooperatorsEmail"] ?? [],
    'testDescription' => $item["testDescription"] ?? '',
    'finalReport' => $item["finalReport"] ?? '',
    'allOptions' => $item["allOptions"] ?? [],
    'allAnswers' => $item["allAnswers"] ?? [],
    'heuristics' => $item["testStructure"] ?? [],
    'generalStatistics' => $item["gstatistics"] ?? [],
    'statisticsTable' => $item["statisticstable"] ?? [],
    'statisticsByEvaluatorAnswer' => $item["statisticsByEvaluatorAnswer"] ?? [],
    'statisticsByHeuristics' => $item["statisticsByHeuristics"] ?? [],
  ];

  // Diretório temporário
  $pdfDir = Storage::path('Temporary PDF');
  Storage::makeDirectory('Temporary PDF');

  // Nome do arquivo final
  $titleSlug = Str::slug(data_get($item, 'title', 'report'), '_');
  $timestamp = now()->format('Ymd_His');
  $filename = "final_report_{$titleSlug}_{$timestamp}.pdf";
  $mergedPath = $pdfDir . "/{$filename}";

  // Gerar o PDF principal
  $pdf = PDF::loadView('pdf.invoice', compact('data'));
  $defaultPath = $pdfDir . '/default.pdf';
  $pdf->save($defaultPath);

  // Mesclar o PDF
  $merge = new \Clegginabox\PDFMerger\PDFMerger;
  $merge->addPDF($defaultPath, 'all');
  $merge->merge('file', $mergedPath, 'P');

  // Obter conteúdo final e limpar
  $pdfStream = file_get_contents($mergedPath);
  unlink($defaultPath);
  unlink($mergedPath);
  Storage::deleteDirectory('public/temp');

  return response($pdfStream, 200)
    ->header('Content-Type', 'application/pdf')
    ->header("Content-Disposition", "attachment; filename=\"{$filename}\"");
});
