<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{{ $data['title'] }}}</title>
    <style>
        /* Reset básico para o PDF */
        body {
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            font-family: Arial, sans-serif;
            color: #333333;
        }

        /* Container geral para seções do documento */
        .page-section {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Título principal (h1) */
        .page-section h1 {
            color:rgb(12, 12, 12);
            padding-bottom: 10px;
            border-bottom: 1px solid #000000;
            margin-top: 0;
        }

        /* Subtítulos (h2, h3) */
        .page-section h2,
        .page-section h3 {
            margin-top: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #ccc;
        }

        /* Parágrafos */
        .page-section p {
            text-align: justify;
            text-indent: 1.5em;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        /* Links padrão */
        a {
            color: black;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Tabela padrão */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            /* Adiciona borda ao redor da tabela */
        }

        table th,
        table td {
            border: 1px solid #ccc;
            /* Bordas internas em cada célula */
            padding: 8px;
            text-align: left;
        }

        table thead {
            background-color: #f2f2f2;
            /* Cabeçalho com fundo suave */
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Pequenos ajustes para elementos específicos */

        .creatorEmail {
            font-weight: 700;
            font-size: 18px;
            text-align: center;
        }

        .cooperatorEmail {
            margin-top: 10px;
            font-size: 15px;
            text-align: center;
        }

        /* Espaçamento entre seções para melhor legibilidade */
        .section-spacing {
            margin-top: 10px;
        }

        /* Ajuste específico para corpo do texto na cover */
        .foreword-container {
            font-family: "Times New Roman", Times, serif;
            padding: 2cm;
            width: 100vw;
            height: 842px;
            /* A4 portrait height */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Evita margens estranhas no rodapé (se usar) */
        @page {
            margin: 20px 30px 40px 50px;
        }
    </style>

</head>

<body>
    @include('pdf.cover')

    <div class="page-break"></div>

    @include('pdf.foreword')

    <div class="page-break"></div>

    @include('pdf.description')

    <div class="page-break"></div>

    @if(isset($data['finalReport']) && $data['finalReport'] != '')
    @include('pdf.finalReport')
    @endif

    @if(isset($data['generalStatistics']) && $data['generalStatistics'] != '' && $data['statistics'] != false)
    <div class="page-break"></div>
    @include('pdf.generalStatistics')
    @endif
    
    <div class="page-break"></div>
    @include('pdf.heuristics')
    </div>
</body>

</html>