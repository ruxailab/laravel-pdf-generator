<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{{ $data['title'] }}}</title>
    <style>
        /* Define styles for the invoice */
        body {
            padding:0px;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .documet{
            padding: 1rem;
        }

        @page {
        margin: 1cm;
    }

    .page-break {
        page-break-before: always;
        page-break-inside: avoid;
        position:absolute;
        bottom:1cm;
        right:1cm;
    }
    </style>
</head>
<body>
@include('pdf.header')
<div class="page-break"></div>
    <div class="documet">
    @if(isset($data['finalReport']) && $data['finalReport'] != '')
        @include('pdf.finalReport')
        <div class="page-break"></div>
    @endif
    
    @if(isset($data['generalStatistics']) && $data['generalStatistics'] != '')
        @include('pdf.generalStatistics')

    @endif
        @include('pdf.heuristics')
    </div>
</body>
<footer class="footer">

</footer>
</html>