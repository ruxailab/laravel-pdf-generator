<!DOCTYPE html>
<html>

<head>
    <title>Heuristic Questions</title>
    <style>
        /* Quebra de página */
        .page-break {
            page-break-before: always;
            page-break-inside: avoid;
            position: absolute;
            bottom: 1cm;
            right: 1cm;
        }

        /* Container para as seções específicas das heurísticas */
        .heuristic {
            background-color: transparent;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Título das perguntas - substitui .heuristic h3.question-title */
        .heuristic .question-title {
            color: #000000;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        /* Perguntas */
        .heuristic .question {
            color: #333333;
            margin-bottom: 10px;
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

        /* Barra de gráfico */
        .bar {
            position: relative;
            width: 100%;
            max-width: 90%;
            height: 20px;
            margin: 10px 0;
            padding: 10px;
            border-radius: 0 5px 5px 0;
            background-color: #2196F3;
            transition: width 0.8s ease-in-out;
            display: flex;
            align-items: center;
            box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .bar::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 1px;
            background-color: #000;
            box-shadow: -2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .bar-value {
            font-size: 20px;
            color: black;
            margin-right: 4px;
            float: right;
            margin-bottom: 100px;
        }

        .value-name {
            font-size: 20px;
            color: black;
            float: left;
            position: absolute;
            white-space: nowrap;
            margin-bottom: 5px;
        }

        .value-name-inside {
            margin-right: 4px;
        }

        .value-name-outside {
            margin-left: 4px;
            color: black;
        }

        /* Comentários */
        .comment-item {
            border: 1px solid #838383;
            border-radius: 5x;
            padding: 10px;
            display: flex;
            align-items: center;
            page-break-inside: avoid;
            margin-bottom: 10px;
        }

        .comment-text {
            background-color: transparent;
            padding: 10px;
            flex: 1;
            text-align: justify;
            text-justify: inter-word;
        }

        .comment-image {
            text-align: center;
            margin-top: 10px;
            margin-left: 10px;
        }

        .center-image {
            max-width: 100%;
            max-height: 80%;
        }
    </style>
</head>

<body>
    <?php

    use App\Helpers\ImageHelper;

    $optionsArray = $data['allOptions'];
    $commentsArray = [];

    foreach ($data['allAnswers'] as $item) {
        foreach ($item['heuristicQuestions'] as $index => $heuristic) {
            foreach ($heuristic['heuristicQuestions'] as $question) {
                $questionId = $question['heuristicId'];
                $comment = $question['heuristicComment'];
                $commentImageUrl = $question['answerImageUrl'];

                if (!isset($commentsArray[$index][$questionId])) {
                    $commentsArray[$index][$questionId] = [];
                }
                $commentsArray[$index][$questionId][] = $comment;

                if (!isset($urlsArray[$index][$questionId])) {
                    $urlsArray[$index][$questionId] = [];
                }
                $urlsArray[$index][$questionId][] = $commentImageUrl;
            }
        }
    }
    ?>

    <div class="page-section">
        <h1 id="test-data">Test Data</h1>

        <h2>Heuristics</h2>
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

        <h2>Test Options</h2>
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

        <div class="page-break"></div>
        <h2>Summary Table per Heuristic</h2>
        @foreach ($data['heuristics'] as $hIndex => $heuristic)
        <h3>H{{ $hIndex + 1 }}: {{ $heuristic['title'] }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    @foreach ($data['allAnswers'] as $reviewIndex => $review)
                    <th>Ev{{ $reviewIndex + 1 }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($heuristic['questions'] as $qIndex => $question)
                <tr>
                    <td>Q{{ $qIndex + 1 }}</td>
                    @foreach ($data['allAnswers'] as $reviewIndex => $review)
                    @php
                    $matchedHeuristic = collect($review['heuristicQuestions'])->firstWhere('heuristicId', $heuristic['id']);
                    $answerData = $matchedHeuristic['heuristicQuestions'][$qIndex] ?? null;
                    $answerValue = $answerData['heuristicAnswer']['value'] ?? '-';
                    @endphp
                    <td style="text-align: center;">{{ $answerValue }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach

        <div class="page-break"></div>

        <h2>Answers by Heuristic</h2>
        @foreach($data['heuristics'] as $key => $item)
        <div class="heuristic">
            <div class="question">
                <h3 class="question-title">Heuristic {{ $key + 1 }}: {{ $item['title'] }}</h3>
            </div>

            <div class="chart">
                <?php
                $heuristicQuestions = $data['heuristics'][$key]['questions'];

                foreach ($heuristicQuestions as $questionIndex => $question) {
                    $questionId = $question['id'];
                    echo '<h4>Q' . ($questionIndex + 1) . ' - ' . $question['title'] . '</h4>';

                    // Summary answers
                    echo '<div class="summary-table" style="margin-bottom: 1rem;">';
                    echo '<table>';
                    echo '<thead><tr><th>Evaluator</th><th>Answer</th><th>Value</th></tr></thead>';
                    echo '<tbody>';

                    foreach ($data['allAnswers'] as $reviewIndex => $review) {
                        $matchedHeuristic = collect($review['heuristicQuestions'])->firstWhere('heuristicId', $item['id']);

                        if (!$matchedHeuristic || empty($matchedHeuristic['heuristicQuestions'][$questionIndex])) {
                            continue;
                        }

                        $answerData = $matchedHeuristic['heuristicQuestions'][$questionIndex];
                        $answerText = $answerData['heuristicAnswer']['text'] ?? '-';
                        $answerValue = $answerData['heuristicAnswer']['value'] ?? '-';

                        echo '<tr>';
                        echo '<td>Ev' . ($reviewIndex + 1) . '</td>';
                        echo '<td>' . $answerText . '</td>';
                        echo '<td>' . $answerValue . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>';

                    // Comments
                    echo '<div class="review-answers">';
                    foreach ($data['allAnswers'] as $reviewIndex => $review) {
                        $matchedHeuristic = collect($review['heuristicQuestions'])->firstWhere('heuristicId', $item['id']);

                        if (!$matchedHeuristic || empty($matchedHeuristic['heuristicQuestions'][$questionIndex])) {
                            continue;
                        }

                        $answerData = $matchedHeuristic['heuristicQuestions'][$questionIndex];
                        $comment = $answerData['heuristicComment'] ?? '';
                        $imageUrl = $answerData['answerImageUrl'] ?? '';

                        if (!empty($comment)) {
                            echo '<div class="comment-item">';
                            echo '<div class="comment-text"><strong>Ev' . ($reviewIndex + 1) . ' comment:</strong> ' . $comment . '</div>';

                            if (!empty($imageUrl)) {
                                echo '<div class="comment-image">';
                                $localImagePath = ImageHelper::saveImageFromUrl($imageUrl);
                                if ($localImagePath) {
                                    echo '<img class="center-image" src="' . $localImagePath . '" alt="Image">';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>