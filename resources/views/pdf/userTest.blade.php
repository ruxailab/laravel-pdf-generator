<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] ?? 'Test Report' }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        h1, h2, h3 {
            margin: 10px 0 5px 0;
        }

        p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 5px;
            vertical-align: top;
        }

        table th {
            background: #f2f2f2;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

<h1>{{ $data['title'] ?? 'Test Report' }}</h1>
<p><strong>Created at:</strong> {{ $data['creationDate'] ?? '-' }}</p>
<p><strong>Creator:</strong> {{ $data['creatorEmail'] ?? '-' }}</p>

<hr>

{{-- USERS --}}
@if(!empty($data['allAnswers']))
    @foreach($data['allAnswers'] as $userId => $user)
        <h2>User: {{ $user['fullName'] ?? 'Anonymous' }}</h2>
        <p><strong>User ID:</strong> {{ $userId }}</p>
        <p><strong>Submitted:</strong> {{ !empty($user['submitted']) ? 'Yes' : 'No' }}</p>

        {{-- PRE TEST --}}
        @if(!empty($user['preTestAnswer']))
            <h3>Pre-Test Answers</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user['preTestAnswer'] as $answer)
                        <tr>
                            <td>{{ $answer['preTestAnswerId'] ?? '-' }}</td>
                            <td>{{ $answer['answer'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- POST TEST --}}
        @if(!empty($user['postTestAnswer']))
            <h3>Post-Test Answers</h3>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user['postTestAnswer'] as $answer)
                        <tr>
                            <td>{{ $answer['title'] ?? '-' }}</td>
                            <td>{{ $answer['answer'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- TASKS --}}
        @if(!empty($user['tasks']))
            <h3>Tasks</h3>

            @foreach($user['tasks'] as $task)
                <p><strong>Task ID:</strong> {{ $task['taskId'] ?? '-' }}</p>
                <p><strong>Completed:</strong> {{ !empty($task['completed']) ? 'Yes' : 'No' }}</p>
                <p><strong>Time (ms):</strong> {{ $task['taskTime'] ?? '-' }}</p>
                <p><strong>Observations:</strong> {{ $task['taskObservations'] ?? '-' }}</p>

                @if(!empty($task['audioRecordURL']))
                    <p><strong>Audio:</strong> {{ $task['audioRecordURL'] }}</p>
                @endif

                @if(!empty($task['screenRecordURL']))
                    <p><strong>Screen:</strong> {{ $task['screenRecordURL'] }}</p>
                @endif

                @if(!empty($task['webcamRecordURL']))
                    <p><strong>Webcam:</strong> {{ $task['webcamRecordURL'] }}</p>
                @endif

                <hr>
            @endforeach
        @endif

        <div class="page-break"></div>
    @endforeach
@endif

</body>
</html>
