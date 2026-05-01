<!DOCTYPE html>
<html>

<head>
    <title>Heuristic Questions</title>
    <style>
        /* Quebra de página */
        .page-break {
            page-break-after: always;
        }

        /* Container para as seções específicas das heurísticas */
        .heuristic {
            background-color: transparent;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        /* Título das perguntas - substitui .heuristic h3.question-title */
        .heuristic .question-title {
            color: #000000;
            font-weight: bold;
            font-size: 22px;
            margin-bottom: 8px;
            margin-top: 8px;
        }

        /* Perguntas */
        .heuristic .question {
            color: #333333;
            margin-bottom: 8px;
        }

        .heuristic .question p {
            margin: 0;
            line-height: 1.4;
        }

        /* Lista de respostas */
        .heuristic .answer {
            margin-left: 10px;
            list-style-type: disc;
        }

        .heuristic .answer li {
            margin-bottom: 5px;
        }

        .heuristic .answer li:last-child {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="page-section">
        <h1 id="heuristic-structure">Heuristic Evaluation Structure</h1>
        
        <p class="section-intro">
            This section outlines the complete structure of the heuristic evaluation framework used in this study. 
            It provides a comprehensive list of all evaluated heuristics with their associated questions, 
            along with the test options and their scoring values used for the evaluation.
        </p>

        <h2 id="heuristics-list">Heuristics</h2>
        <table>
            <thead>
                <tr>
                    <th>Heuristic</th>
                    <th>Questions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['heuristics'] as $index => $heuristic)
                <tr>
                    <td>{{ $index + 1 }}. {{ $heuristic['title'] }}</td>
                    <td>
                        <ul>
                            @foreach ($heuristic['questions'] as $question)
                            <li>{{ $question['title'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 id="heuristic-answers">Heuristic possible answers</h2>
        <div class="options">
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
                        <td>{{$option['text']}}</td>
                        <td>{{$option['description']}}</td>
                        <td>{{$option['value'] !== null ? $option['value'] : 'null'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
