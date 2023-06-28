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
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #FFA600;
        }
        .statistic h2{
            margin-top: 0;
            margin-left: 10px;
            padding-bottom: 2px;
        }

        .statistic p {
            text-align: justify;
            text-indent: 1.5em;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        /* Data and content settings */
        .data {
            margin-top: 20px;
            padding: 10px;
            background-color: #F5F5F5;
            border: 1px solid #CCCCCC;
            border-radius: 4px;
        }

        .data p {
            margin: 5px 0;
        }
        .chip {
            display: inline-block;
            text-align: center;
            width: 100%;
            padding: 5px;
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
    </style>
</head>
<body>
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
                <h2>Individual statistics</h2>
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
                    </tbody>
                </table>
                <hr>
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
                                <td>{{ $option['text'] }}</td>
                                <td>{{ $option['description'] }}</td>
                                <td>{{ $option['value'] !== null ? $option['value'] : 'null' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
