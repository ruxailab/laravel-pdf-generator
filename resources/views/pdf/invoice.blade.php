<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{{ $data['title'] }}}</title>
    <style>
        /* Define styles for the invoice */
        body {
            padding:0px !important;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
@include('pdf.body')s
<div class="page-break"></div>
@include('pdf.abstract')
<div class="page-break"></div>
@include('pdf.heuristics')
</body>
<footer class="footer">

</footer>
</html>