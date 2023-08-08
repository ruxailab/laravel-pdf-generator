<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Structure body settings */ 
        body {
            margin: 10px;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Table settings */
        tbody tr:nth-child(even) {
            background-color: #DDDDDD;  
            border-radius: 50px;
        }

        table {
            padding: 1rem;
            table-layout: fixed; /* Fixed table layout */
            width: 100%; /* Full width */
        }

        .table-content {
            font-size: 12px; /* Adjust the font size as needed */
            padding: 10px; /* Increase padding for content cells */
            text-align: center; /* Center-align content */
        }

        .table-header-content {
            font-size: 14px;
            padding: 10px; /* Increase padding for header cells */
            text-align: center; /* Center-align headers */
        }

        .chip {
            display: inline-block;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Heuristic Statistics</h2>
    @if (isset($data['heuristicStatistics']) && !empty($data['heuristicStatistics']))
        <table>
            <thead>
                <tr>
                    @foreach ($data['heuristicStatistics']['header'] as $header)
                        <th class="table-header-content"><span class="chip">{{ $header['text'] }}</span></th>
                    @endforeach
                    <th class="table-header-content"><span class="chip">Average</span></th> <!-- Added average column header -->
                    <th class="table-header-content"><span class="chip">Maximum</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['heuristicStatistics']['items'] as $index => $item)
                    @if (isset($item) && in_array(($index+1), $data['selectedHeuristics']))

                    <tr>
                        <td class="table-content">{{ $data['heuristics'][$index]['title'] }}</td>
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
                        <td class="table-content"><span class="chip">{{ number_format($total / (count($data['heuristicStatistics']['header']) - 1), 2) }}</span></td>
                        <td class="table-content"><span class="chip">{{ $item['max'] }}</span></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available.</p>
    @endif
</body>
</html>
