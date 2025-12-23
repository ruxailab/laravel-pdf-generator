<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] ?? 'Report' }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1, h2, h3 {
            margin: 0 0 10px 0;
        }

        p {
            line-height: 1.5;
            margin: 0 0 10px 0;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        table thead {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 30px;
        }
    </style>
</head>

<body>

{{-- COVER --}}
@if(view()->exists('pdf.cover'))
    @include('pdf.cover')
    <div class="page-break"></div>
@endif

{{-- FOREWORD --}}
@if(view()->exists('pdf.foreword'))
    @include('pdf.foreword')
    <div class="page-break"></div>
@endif

{{-- DESCRIPTION --}}
@if(view()->exists('pdf.description'))
    @include('pdf.description')
    <div class="page-break"></div>
@endif

{{-- FINAL REPORT --}}
@if(view()->exists('pdf.finalReport'))
    @include('pdf.finalReport')
    <div class="page-break"></div>
@endif

{{-- GENERAL STATISTICS --}}
@if(view()->exists('pdf.generalStatistics'))
    <include('pdf.generalStatistics')
    <div class="page-break"></div>
@endif

{{-- HEURISTICS --}}
@if(view()->exists('pdf.heuristics'))
    @include('pdf.heuristics')
@endif

</body>
</html>
