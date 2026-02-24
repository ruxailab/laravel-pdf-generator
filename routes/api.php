<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

Route::post('/generate-pdf', function (Request $request) {
    ini_set('max_execution_time', 600);

    try {
        if (!$request->getContent()) {
            return response()->json([
                'error' => 'Empty request body',
            ], 400);
        }

        $test = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'error' => 'Invalid JSON payload',
            ], 400);
        }

        $item = $test['payload'] ?? null;

        if (!$item) {
            return response()->json([
                'error' => 'No item found to generate PDF',
            ], 400);
        }

        $data = [
            'title' => $item['title'] ?? '',
            'creationDate' => $item['creationDate'] ?? '',
            'creatorEmail' => $item['creatorEmail'] ?? '',
            'cooperatorsEmail' => $item['cooperatorsEmail'] ?? [],
            'description' => $item['description'] ?? '',
            'testDescription' => $item['testDescription'] ?? '',
            'finalReport' => $item['finalReport'] ?? '',
            'allOptions' => $item['allOptions'] ?? [],
            'allAnswers' => $item['allAnswers'] ?? [],
            'heuristics' => $item['testStructure'] ?? [],
            'generalStatistics' => $item['generalStatistics'] ?? [],
            'statisticsTable' => $item['statisticsTable'] ?? [],
            'statisticsByEvaluatorAnswer' => $item['statisticsByEvaluatorAnswer'] ?? [],
            'statisticsByHeuristics' => $item['statisticsByHeuristics'] ?? [],
        ];

        $testType = $item['type'] ?? 'HEURISTIC';

        if ($testType === 'USER') {
            $view = 'pdf.userTest';
            $data['allAnswers'] = $item['taskAnswers'] ?? [];
        } else {
            $view = 'pdf.invoice';
            $data['allAnswers'] = $item['allAnswers'] ?? [];
        }

        if (!view()->exists($view)) {
            return response()->json([
                'error' => "PDF layout not found: {$view}",
            ], 500);
        }

        $titleSlug = Str::slug(data_get($item, 'title', 'report'), '_');
        $timestamp = now()->format('Ymd_His');
        $filename = "final_report_{$titleSlug}_{$timestamp}.pdf";

        $pdf = Pdf::loadView($view, ['data' => $data]);
        $pdfStream = $pdf->output();

        return response($pdfStream, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    } catch (\Throwable $e) {
        $errorId = (string) Str::uuid();

        Log::error('PDF generation failed', [
            'error_id' => $errorId,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'error' => 'Failed to generate PDF',
            'error_id' => $errorId,
            'error_code' => 'PDF_GENERATION_ERROR',
            'debug' => config('app.debug') ? [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ] : null,
        ], 500);
    }
});
