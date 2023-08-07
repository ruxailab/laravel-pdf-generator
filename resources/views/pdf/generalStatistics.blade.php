<!DOCTYPE html>
<html>
<head>
    <title>Article Abstract</title>
    <style>
        @media print {
            body {
                padding: 20mm;
            }

            .statistic {
                display: block;
                width: 100%;
                height: 100%;
                box-sizing: border-box;
            }

            .statistic-content {
                max-width: 170mm;
                margin: 0 auto;
                padding: 0;
                background-color: #FFFFFF;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }
        }
        /* Structure body settings */ 
        body {
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
            color: #333333;
        }

        .statistic {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .statistic-content {
            max-width: 800px;
            padding: 20px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .statistic h1 {
            color: #FFA600;
            padding-bottom: 10px;
            border-bottom: 1px solid #FFA600;
        }
        .statistic h2{
            margin-top:10px !important;
            margin-left: 10px;
            padding-bottom: 2px;
        }

        .statistic p {
            text-align: justify;
            text-indent: 1.5em;
            line-height: 1.5;
            margin-bottom: 2px;
        }

        /* Data and content settings */
        .data {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
        }

        .data p {
            margin: 2px 0;
        }
        .chip {
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        hr {
            height: 4px;
            background-color: #FFA500;
            border: none;
            margin: 20px 0;
            border-radius: 10px;
        }

        /* Table settings */
        tbody tr:nth-child(even) {
            background-color: #DDDDDD;  
            border-radius: 10px;
        }

        table{
            padding: 1rem;
        }
        .table-content {
            font-size: 12px; /* Adjust the font size as needed */
        }
        .table-header-content{
            font-size:14px;
        }
    </style>
</head>
<body>
<?php 
    // Calculate the average of all results
    $totalResults = 0;
    $totalAplication = 0;
    $totalNoAplication = 0;
    $totalAnswered = 0;
    $numRows = count($data['statisticsTable']['items']);
    foreach ($data['statisticsTable']['items'] as $item) {
        $totalResults += $item['result'];
        $totalAplication += $item['aplication'];
        $totalNoAplication += $item['noAplication'];
        $totalAnswered += $item['answered'];
    }
    $averageResult = $numRows > 0 ? $totalResults / $numRows : 0;
    $averageAplication = $numRows > 0 ? $totalAplication / $numRows : 0;
    $averageNoAplication = $numRows > 0 ? $totalNoAplication / $numRows : 0;
    $averageAnswered = $numRows > 0 ? $totalAnswered / $numRows : 0;

    // Retrieve the last item from the array to update the last row with the averages
    $lastItem = end($data['statisticsTable']['items']);
    $lastItem['result'] = $averageResult;
    $lastItem['aplication'] = $averageAplication;
    $lastItem['noAplication'] = $averageNoAplication;
    $lastItem['answered'] = $averageAnswered;

?>

    <div class="statistic">
        <div class="statistic-content">
            <h1>Statistics</h1>
            <div class="data">
                <h2>General statistics</h2>
                <p>Usability percentage: {{ $data['generalStatistics']['average'] }}</p>
                <p>Max: {{ $data['generalStatistics']['max'] }}</p>
                <p>Min: {{ $data['generalStatistics']['min'] }}</p>
                <p>Standard Deviation: {{ $data['generalStatistics']['sd'] }}</p>
                <p>Total test questions(s): {{ $data['statisticsTable']['items'][0]['aplication'] + $data['statisticsTable']['items'][0]['noAplication'] }}</p>
                <hr>
                <h2>Individual test statistics</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Evaluator</th>
                            <th>Result</th>
                            <th>Aplication</th>
                            <th>No Aplication</th>
                            <th>Answered (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['statisticsTable']['items'] as $item)
                            <tr>
                                <td><span class="chip">{{ $item['evaluator'] }}</span></td>
                                <td>
                                    <span class="chip">
                                        {{ $item['result'] }}%
                                    </span>
                                </td>
                                <td><span class="chip">{{ $item['aplication'] }}</span></td>
                                <td><span class="chip">{{ $item['noAplication'] }}</span></td>
                                <td><span class="chip">{{ $item['answered'] }}%</span></td>
                            </tr>
                           
                        @endforeach
                        <tr>
                            <td style="text-align: center; "><strong>Average</strong></td>
                            <td><span class="chip">{{ number_format($averageResult, 2) }}%</span></td>
                            <td><span class="chip">{{ number_format($averageAplication, 2) }}</span></td>
                            <td><span class="chip">{{ number_format($averageNoAplication, 2) }}</span></td>
                            <td><span class="chip">{{ number_format($averageAnswered, 2) }}%</span></td>
                        </tr>
                    </tbody>
                </table>
                <hr>

                <h2>Heuristic Statistics</h2>
@if (isset($data['heuristicStatistics']) && !empty($data['heuristicStatistics']))
        <table>
            <thead>
                <tr>
                    @foreach ($data['heuristicStatistics']['header'] as $header)
                        <th class="table-header-content "><span class="chip">{{ $header['text'] }}</span></th>
                    @endforeach
                    <th class="table-header-content "><span class="chip">Average</span></th> <!-- Added average column header -->
                    <th class="table-header-content "><span class="chip">Maximum</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['heuristicStatistics']['items'] as  $index => $item)
                    @if (isset($item) && in_array( ($index+1), $data['selectedHeuristics']))

                    <tr>
                        <td class="table-content" style="width: 15rem; line-height: 1.5; text-align: justify; padding:8px;  border-right: 1px solid rgba(128, 128, 128, 0.3);">{{ $data['heuristics'][$index]['title'] }}</td>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($data['heuristicStatistics']['header'] as $evaluatorIndex => $header)
                            @if ($header['value'] !== 'heuristic')
                                @php
                                    $total += floatval($item['Ev' . $evaluatorIndex . '']);
                                @endphp
                                <td class="table-content"><span class="chip">{{ $item['Ev' . $evaluatorIndex . ''] }}</span></td>
                            @endif
                        @endforeach
                        <td class="table-content"><span class="chip">{{ number_format($total / (count($data['heuristicStatistics']['header']) - 1),2) }}</span></td>
                        <td class="table-content"><span class="chip">{{ $item['max'] }}</span></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available.</p>
@endif
                <hr>   

                @if(isset($data['testOptions']) && $data['testOptions'] != '')
                    <div class="options">
                        <h2>Test Options</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Name</th>
                                        <th style="text-align: left;">Description</th>
                                        <th style="text-align: left;">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['testOptions'] as $option)
                                        <tr>
                                            <td>{{$option['text']}}</td>
                                            <td>{{$option['description']}}</td>
                                            <td>{{$option['value'] !== null ? $option['value'] : 'null'}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>      
                @endif
            </div>
        </div>
    </div>
</body>
</html>
