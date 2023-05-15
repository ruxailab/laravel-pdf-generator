<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        /* Define styles for the invoice */
        body {
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
        page-break-inside: auto;
        position:absolute;
        bottom:1cm;
        right:1cm;
    }
    </style>
</head>
<body>
@include('pdf.header')
<div class="page-break">HELLO WORLD</div>
@include('pdf.body')
<div class="page-break">HELLO WORLD</div>
  
    
</body>
<footer class="footer">

</footer>
</html>