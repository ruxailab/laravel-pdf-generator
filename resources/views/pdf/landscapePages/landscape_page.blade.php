<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
        .chip {
            display: inline-block;
            text-align: center;
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
</body>
</html>
