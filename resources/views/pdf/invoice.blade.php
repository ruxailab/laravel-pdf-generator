<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{{ $data['title'] }}}</title>
    <style>
        /* Define styles for the invoice */
        body {
            padding: 0px;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .documet {
            padding: 1rem;
        }

        @page {
            margin: 1cm;
        }

        .page-break {
            page-break-before: always;
            page-break-inside: avoid;
            position: absolute;
            bottom: 1cm;
            right: 1cm;
        }
    </style>
</head>

<body>
    <!-- option-1 -->
    @include('pdf.cover')
    
    <div class="page-break"></div>
    
    @include('pdf.foreword')
    
    <div class="page-break"></div>
    @if(isset($data['allOptions']) && $data['allOptions'] != '')
    @include('pdf.allOptions')
    @endif
    <div class="page-break"></div>
    
    @include('pdf.description')

    @if(isset($data['finalReport']) && $data['finalReport'] != '')
    @include('pdf.finalReport')

    @endif

    @if(isset($data['generalStatistics']) && $data['generalStatistics'] != '' && $data['statistics'] != false)
    <div class="page-break"></div>
    @include('pdf.generalStatistics')
    @endif

    @include('pdf.heuristics')


    </div>
</body>

</html>