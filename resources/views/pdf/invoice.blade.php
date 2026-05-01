<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] ?? 'Heuristic Evaluation Report' }}</title>
    
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

        .cover-collaborators {
            font-size: 10pt;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 15mm;
            font-style: italic;
        }

        .cover-collaborators .creator {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cover-collaborators .cooperator {
            font-size: 9pt;
            margin-top: 3px;
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
            margin: 0 0 15px 0;
        }

        h2 {
            font-size: 16pt;
            color: #34495e;
            margin: 15px 0 10px 0;
            border-left: 4px solid #ff425A;
            padding-left: 12px;
        }

        h3 {
            font-size: 12pt;
            color: #555;
            margin: 10px 0 8px 0;
            font-weight: bold;
        }

        h4 {
            font-size: 11pt;
            color: #666;
            margin: 8px 0 6px 0;
            font-weight: bold;
        }

        p {
            line-height: 1.6;
            margin: 0 0 10px 0;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            background: white;
        }

        table th {
            background: #002D51;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
        }

        table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 9pt;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        table ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        table ul li {
            margin: 2px 0;
        }

        .page-break {
            page-break-after: always;
        }

        .page-section {
            margin-bottom: 15px;
        }

        .section-spacing {
            margin: 15px 0;
        }

        .index-link {
            display: block;
            color: #002D51;
            text-decoration: none;
            padding: 8px 0;
            font-size: 11pt;
            border-bottom: 1px solid #ecf0f1;
        }

        .index-link:hover {
            color: #ff425A;
        }

        .index-sublink {
            display: block;
            color: #666;
            text-decoration: none;
            padding: 6px 0 6px 20px;
            font-size: 10pt;
            border-bottom: 1px solid #f5f5f5;
        }

        .index-sublink:hover {
            color: #ff425A;
        }

        .section-intro {
            color: #555;
            font-size: 10pt;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: justify;
            font-style: italic;
        }

        .report-body {
            text-align: justify;
            line-height: 1.6;
        }

        /* Heuristics specific styles */
        .heuristic {
            background-color: transparent;
            margin-bottom: 15px;
        }

        .heuristic .question-title {
            color: #2c3e50;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .heuristic .question {
            color: #333333;
            margin-bottom: 10px;
        }

        .comment-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 10px;
            background: #f8f9fa;
            page-break-inside: avoid;
        }

        .comment-text {
            padding: 10px;
            text-align: justify;
        }

        .comment-image {
            text-align: center;
            margin-top: 10px;
        }

        .center-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
        }

        .summary-table {
            margin-bottom: 15px;
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
        
        <h1 class="cover-title">{{ $data['title'] ?? 'Heuristic Evaluation Report' }}</h1>
        
        @if(!empty($data['description']))
        <div class="cover-description">
            {{ $data['description'] }}
        </div>
        @endif
        
        <div class="cover-date">
            @php
                $timestamp = $data['creationDate'] ?? time() * 1000;
                $dateTime = new DateTime('@' . floor($timestamp / 1000));
                echo $dateTime->format('F j, Y');
            @endphp
        </div>

        @if(!empty($data['creatorEmail']) || !empty($data['cooperatorsEmail']))
        <div class="cover-collaborators">
            @if(!empty($data['creatorEmail']))
            <div class="creator">
                {{ $data['creatorEmail'] }}
            </div>
            @endif

            @php
                $cooperators = is_array($data['cooperatorsEmail']) ? $data['cooperatorsEmail'] : [$data['cooperatorsEmail']];
            @endphp

            @foreach($cooperators as $email)
                @if(!empty($email))
                <div class="cooperator">
                    {{ $email }}
                </div>
                @endif
            @endforeach
        </div>
        @endif
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

{{-- TABLE OF CONTENTS --}}
<div class="page-section">
    <h1>Table of Contents</h1>

    @php
        $sectionNumber = 1;
    @endphp

    @if(!empty($data['testDescription']))
        <a class="index-link" href="#description-section">{{ $sectionNumber }}. Study Description</a>
        @php $sectionNumber++; @endphp
    @endif

    @if(!empty($data['finalReport']))
        <a class="index-link" href="#final-report">{{ $sectionNumber }}. Final Report Conclusion</a>
        @php $sectionNumber++; @endphp
    @endif

    @if(!empty($data['heuristics']))
        @php $structureSection = $sectionNumber; @endphp
        <a class="index-link" href="#heuristic-structure">{{ $sectionNumber }}. Heuristic Evaluation Structure</a>
        <a class="index-sublink" href="#heuristics-list">{{ $sectionNumber }}.1 Heuristics</a>
        @if(!empty($data['allOptions']))
            <a class="index-sublink" href="#heuristic-answers">{{ $sectionNumber }}.2 Heuristic possible answers</a>
        @endif
        @php $sectionNumber++; @endphp
    @endif

    @if(!empty($data['generalStatistics']) || !empty($data['statisticsTable']) || !empty($data['statisticsByEvaluatorAnswer']) || !empty($data['statisticsByHeuristics']))
        @php 
            $statsSection = $sectionNumber;
            $subSection = 1;
        @endphp
        <a class="index-link" href="#statistics">{{ $sectionNumber }}. Statistics</a>
        
        @if(!empty($data['generalStatistics']))
            <a class="index-sublink" href="#general-statistics">{{ $sectionNumber }}.{{ $subSection }} General statistics</a>
            @php $subSection++; @endphp
        @endif
        
        @if(!empty($data['allAnswers']))
            <a class="index-sublink" href="#distribution-answers">{{ $sectionNumber }}.{{ $subSection }} Distribution of Answers by Evaluator</a>
            @php $subSection++; @endphp
        @endif
        
        @if(!empty($data['statisticsTable']['items']))
            <a class="index-sublink" href="#individual-statistics">{{ $sectionNumber }}.{{ $subSection }} Individual test statistics</a>
            @php $subSection++; @endphp
        @endif
        
        @if(!empty($data['statisticsByEvaluatorAnswer']['items']))
            <a class="index-sublink" href="#answers-by-evaluator">{{ $sectionNumber }}.{{ $subSection }} Answers by Evaluator</a>
            @php $subSection++; @endphp
        @endif
        
        @if(!empty($data['statisticsByHeuristics']['items']))
            <a class="index-sublink" href="#answers-by-heuristics-stats">{{ $sectionNumber }}.{{ $subSection }} Answers by Heuristics</a>
            @php $subSection++; @endphp
        @endif
        
        @php $sectionNumber++; @endphp
    @endif

    @if(!empty($data['heuristics']) && !empty($data['allAnswers']))
        @php 
            $dataSection = $sectionNumber;
            $subSection = 1;
        @endphp
        <a class="index-link" href="#study-data">{{ $sectionNumber }}. Study Data</a>
        <a class="index-sublink" href="#summary-tables">{{ $sectionNumber }}.{{ $subSection }} Summary Table per Heuristic</a>
        @php $subSection++; @endphp
        <a class="index-sublink" href="#answers-by-heuristic">{{ $sectionNumber }}.{{ $subSection }} Answers by Heuristic</a>
        @php $sectionNumber++; @endphp
    @endif
</div>

<div class="page-break"></div>

{{-- DESCRIPTION --}}
@if(!empty($data['testDescription']))
<div id="description-section" class="page-section">
    <h1>Study Description</h1>

    <div>
        {!! nl2br(e($data['testDescription'])) !!}
    </div>
</div>

<div class="page-break"></div>
@endif

{{-- FINAL REPORT --}}
@if(!empty($data['finalReport']))
<div id="final-report" class="page-section">
    <h1>Report Conclusion</h1>
    <div class="report-body">
        {!! $data['finalReport'] !!}
    </div>
</div>

<div class="page-break"></div>
@endif

{{-- HEURISTIC STRUCTURE --}}
@if(!empty($data['heuristics']) && view()->exists('pdf.heuristicStructure'))
    @include('pdf.heuristicStructure')
    <div class="page-break"></div>
@endif

{{-- GENERAL STATISTICS --}}
@if((!empty($data['generalStatistics']) || !empty($data['statisticsTable']) || !empty($data['statisticsByEvaluatorAnswer']) || !empty($data['statisticsByHeuristics'])) && view()->exists('pdf.generalStatistics'))
    @include('pdf.generalStatistics')
    <div class="page-break"></div>
@endif

{{-- STUDY DATA --}}
@if(!empty($data['heuristics']) && !empty($data['allAnswers']) && view()->exists('pdf.studyData'))
    @include('pdf.studyData')
@endif

</body>
</html>
