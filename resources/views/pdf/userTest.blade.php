<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] ?? 'User Test Report' }}</title>
    
    <style>
        @page {
            margin: 18mm 15mm 15mm 15mm;
        }

        /* Header con logo */
        #header {
            position: fixed;
            top: -13mm;
            left: 0;
            right: 0;
            height: 8mm;
            text-align: right;
            padding-right: 15mm;
        }

        #header img {
            height: 6mm;
            margin-top: 2mm;
        }

        /* Footer con numeración */
        #footer {
            position: fixed;
            bottom: -10mm;
            left: 0;
            right: 0;
            height: 8mm;
            font-size: 7pt;
            color: #bdc3c7;
            padding-left: 0mm;
            padding-right: 0mm;
        }

        #footer table {
            width: 100%;
            border: none;
            margin: 0;
            padding: 0;
        }

        #footer table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        #footer img {
            height: 7mm;
            display: block;
        }

        #footer .page-number:after {
            content: counter(page);
        }

        /* Cover page styles */
        .cover-page {
            position: absolute;
            top: -18mm;
            left: -15mm;
            right: -15mm;
            bottom: -15mm;
            width: calc(100% + 30mm);
            min-height: 297mm;
            background: #002D51;
            color: white;
            page-break-after: always;
            display: table;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .cover-content {
            display: table-cell;
            vertical-align: middle;
            padding: 40mm 30mm;
            text-align: left;
        }

        .cover-logo {
            margin-bottom: 30mm;
        }

        .cover-logo img {
            height: 15mm;
        }

        .cover-title {
            font-size: 32pt;
            font-weight: bold;
            margin: 0 0 3mm 0;
            line-height: 1.2;
            color: white;
        }

        .cover-description {
            font-size: 13pt;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            max-width: 140mm;
            margin: 0;
            text-align: left;
        }

        .cover-date {
            font-size: 10pt;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 20mm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            font-size: 24pt;
            color: #2c3e50;
            border-bottom: 3px solid #ff425A;
            padding-bottom: 10px;
            margin: 0 0 20px 0;
        }

        h2 {
            font-size: 16pt;
            color: #34495e;
            margin: 25px 0 15px 0;
            border-left: 4px solid #ff425A;
            padding-left: 12px;
        }

        h3 {
            font-size: 12pt;
            color: #555;
            margin: 15px 0 10px 0;
            font-weight: bold;
        }

        h4 {
            font-size: 11pt;
            color: #666;
            margin: 10px 0 8px 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background: white;
        }

        table th {
            background: #002D51;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 9pt;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .chart-container {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

        .bar-chart {
            width: 100%;
            margin: 10px 0;
        }

        .bar-row {
            margin: 5px 0;
            width: 100%;
            page-break-inside: avoid;
        }

        .bar-label {
            display: inline-block;
            width: 28%;
            font-size: 9pt;
            vertical-align: middle;
            padding-right: 5px;
        }

        .bar-container {
            display: inline-block;
            width: 57%;
            height: 16px;
            background: #ecf0f1;
            border-radius: 8px;
            overflow: hidden;
            vertical-align: middle;
        }

        .bar-fill {
            height: 100%;
            border-radius: 8px;
            display: block;
        }

        .bar-fill.success { background: #2ecc71; }
        .bar-fill.warning { background: #f39c12; }
        .bar-fill.danger { background: #e74c3c; }

        .bar-value {
            display: inline-block;
            width: 13%;
            font-size: 9pt;
            font-weight: bold;
            text-align: right;
            vertical-align: middle;
            padding-left: 5px;
        }
            text-align: right;
            vertical-align: middle;
            padding-left: 5px;
        }

        .chart-cards-grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }

        .chart-card {
            display: table-cell;
            width: 48%;
            padding: 15px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            vertical-align: top;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
        }

        .badge-success { background: #2ecc71; color: white; }
        .badge-danger { background: #e74c3c; color: white; }
        .badge-warning { background: #f39c12; color: white; }
        .badge-info { background: #3498db; color: white; }

        .page-break { page-break-after: always; }
        
        hr {
            border: none;
            border-top: 2px solid #ecf0f1;
            margin: 25px 0;
        }
    </style>
</head>

<body>

<!-- Cover Page -->
<div class="cover-page">
    <div class="cover-content">
        <div class="cover-logo">
            <img src="{{ public_path('images/Imagotip_2.png') }}" alt="Logo" />
        </div>
        
        <h1 class="cover-title">{{ $data['title'] ?? 'User Test Report' }}</h1>
        
        @if(!empty($data['description']))
        <div class="cover-description">
            {{ $data['description'] }}
        </div>
        @endif
        
        <div class="cover-date">
            {{ date('F Y') }}
        </div>
    </div>
</div>

<!-- Header con logo -->
<div id="header">
    <img src="{{ public_path('images/Imagotip_1.png') }}" alt="Logo" />
</div>

<!-- Footer con numeración de páginas -->
<div id="footer">
    <table>
        <tr>
            <td style="width: 25%; text-align: left;">
                <img src="{{ public_path('images/Isotip_1.png') }}" alt="Logo" />
            </td>
            <td style="width: 50%; text-align: center;">
                Page <span class="page-number"></span>
            </td>
            <td style="width: 25%;">
            </td>
        </tr>
    </table>
</div>

<?php
// CALCULATE ALL STATISTICS
$taskAnswers = $data['allAnswers'] ?? [];
$totalUsers = count($taskAnswers);
$submittedUsers = 0;
$totalTasks = 0;
$completedTasks = 0;
$attemptedTasks = 0;
$totalTime = 0;
$taskCount = 0;

$nasaTlxGlobal = [
    'mentalDemand' => [],
    'physicalDemand' => [],
    'temporalDemand' => [],
    'performance' => [],
    'effort' => [],
    'frustration' => []
];

foreach ($taskAnswers as $user) {
    if (!empty($user['submitted'])) {
        $submittedUsers++;
    }
    
    if (!empty($user['tasks'])) {
        foreach ($user['tasks'] as $task) {
            $totalTasks++;
            
            if (!empty($task['attempted'])) {
                $attemptedTasks++;
            }
            
            if (!empty($task['completed'])) {
                $completedTasks++;
            }
            
            if (!empty($task['taskTime'])) {
                $totalTime += $task['taskTime'];
                $taskCount++;
            }
            
            if (!empty($task['nasaTlxAnswers'])) {
                foreach ($task['nasaTlxAnswers'] as $key => $value) {
                    if (isset($nasaTlxGlobal[$key]) && is_numeric($value)) {
                        $nasaTlxGlobal[$key][] = $value;
                    }
                }
            }
        }
    }
}

$completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
$attemptRate = $totalTasks > 0 ? round(($attemptedTasks / $totalTasks) * 100, 1) : 0;
$avgTime = $taskCount > 0 ? round($totalTime / $taskCount) : 0;
$submissionRate = $totalUsers > 0 ? round(($submittedUsers / $totalUsers) * 100, 1) : 0;

$nasaTlxAvg = [];
foreach ($nasaTlxGlobal as $key => $values) {
    $nasaTlxAvg[$key] = count($values) > 0 ? round(array_sum($values) / count($values), 1) : 0;
}

// Calculate overall workload for use in effectiveness-efficiency partial
$overallWorkload = count($nasaTlxAvg) > 0 ? round(array_sum($nasaTlxAvg) / count($nasaTlxAvg), 1) : 0;
?>

<h1>{{ $data['title'] ?? 'User Test Report' }}</h1>

{{-- Executive Summary - One Pager --}}
@include('pdf.partials.executive-summary')

<hr>

@include('pdf.partials.pretest-analysis')
@include('pdf.partials.posttest-analysis')

@if(!empty($nasaTlxAvg) && array_sum($nasaTlxAvg) > 0)
<div class="page-break"></div>
@include('pdf.partials.nasa-tlx-analysis')
@endif

<div class="page-break"></div>

@include('pdf.partials.user-details')

</body>
</html>

