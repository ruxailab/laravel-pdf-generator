<!DOCTYPE html>
<html>
<head>
    <title>Test Options</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
            color: #333333;
        }

        .options {
            margin: 20px;
            padding: 20px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .options h2 {
            color: #FFA600;
            padding-bottom: 10px;
            border-bottom: 1px solid #FFA600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #CCCCCC;
        }

        th {
            background-color: #F5F5F5;
        }

        tbody tr:nth-child(even) {
            background-color: #DDDDDD;
        }

        tbody tr:nth-child(odd) {
            background-color: #FFFFFF;
        }
    </style>
</head>
<body>
@if(isset($data['allOptions']) && $data['allOptions'] != '')
    <div class="options">
        <h2>Test Options</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['allOptions'] as $option)
                    <tr>
                        <td>{{ $option['text'] }}</td>
                        <td>{{ $option['description'] ?? 'N/A' }}</td>
                        <td>{{ $option['value'] !== null ? $option['value'] : 'null' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</body>
</html>
