<!DOCTYPE html>
<html>

<head>
    <title>Study Data</title>
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

        /* Barra de gráfico */
        .bar {
            position: relative;
            width: 100%;
            max-width: 90%;
            height: 18px;
            margin: 8px 0;
            padding: 8px;
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

        /* Comments and Images */
        .comment-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 12px;
            background: #f8f9fa;
        }

        .comment-text {
            padding: 8px 0;
            text-align: justify;
            line-height: 1.6;
            color: #333;
        }

        .comment-text strong {
            color: #002D51;
        }

        .comment-image {
            text-align: center;
            margin-top: 10px;
            padding: 8px;
            background: white;
            border-radius: 5px;
        }

        .comment-image strong {
            color: #002D51;
            font-size: 10pt;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        .center-image {
            max-width: 100%;
            max-height: 300px;
            height: auto;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .summary-table {
            margin-bottom: 15px;
        }

        /* Admin Comments for Heuristics */
        .admin-comment-box {
            background: #fffbea;
            border-left: 4px solid #ff425A;
            padding: 12px 15px;
            margin: 15px 0 20px 0;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .admin-comment-label {
            color: #002D51;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
            display: block;
        }

        .admin-comment-text {
            color: #333;
            font-size: 10pt;
            line-height: 1.6;
            text-align: justify;
        }
    </style>
</head>

<body>
    <?php
    use App\Helpers\ImageHelper;
    ?>

    <div class="page-section">
        <h1 id="study-data">Study Data</h1>
        
        <p class="section-intro">
            This section contains the detailed evaluation results gathered from all participants. 
            It includes summary tables showing individual responses per heuristic, 
            administrator's summaries for each heuristic, visual charts displaying answer distributions, 
            and all evaluator comments with supporting images.
        </p>

        <h2 id="summary-tables">Summary Table per Heuristic</h2>
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

        <h2 id="answers-by-heuristic">Answers by Heuristic</h2>
        @foreach($data['heuristics'] as $key => $item)
        <div class="heuristic">
            <div class="question">
                <h3 class="question-title">Heuristic {{ $key + 1 }}: {{ $item['title'] }}</h3>
            </div>

            {{-- Admin Comment for this Heuristic --}}
            @php
                $heuristicComments = $data['heuristicComments'] ?? [];
                $adminComment = $heuristicComments[$key] ?? null;
            @endphp
            @if(!empty($adminComment))
            <div class="admin-comment-box">
                <span class="admin-comment-label">Heuristic Summary</span>
                <div class="admin-comment-text">{!! $adminComment !!}</div>
            </div>
            @endif

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

                    // Comments and Images
                    echo '<div class="review-answers">';
                    foreach ($data['allAnswers'] as $reviewIndex => $review) {
                        $matchedHeuristic = collect($review['heuristicQuestions'])->firstWhere('heuristicId', $item['id']);

                        if (!$matchedHeuristic || empty($matchedHeuristic['heuristicQuestions'][$questionIndex])) {
                            continue;
                        }

                        $answerData = $matchedHeuristic['heuristicQuestions'][$questionIndex];
                        $comment = $answerData['heuristicComment'] ?? '';
                        $imageUrl = $answerData['answerImageUrl'] ?? '';

                        // Show block if there's a comment OR an image
                        if (!empty($comment) || !empty($imageUrl)) {
                            echo '<div class="comment-item">';
                            
                            // Show comment if exists
                            if (!empty($comment)) {
                                echo '<div class="comment-text"><strong>Ev' . ($reviewIndex + 1) . ' comment:</strong> ' . $comment . '</div>';
                            }

                            // Show image if exists
                            if (!empty($imageUrl)) {
                                echo '<div class="comment-image">';
                                if (!empty($comment)) {
                                    echo '<strong>Ev' . ($reviewIndex + 1) . ' image:</strong><br>';
                                } else {
                                    echo '<strong>Ev' . ($reviewIndex + 1) . ':</strong><br>';
                                }
                                $localImagePath = ImageHelper::saveImageFromUrl($imageUrl);
                                if ($localImagePath) {
                                    echo '<img class="center-image" src="' . $localImagePath . '" alt="Evaluator Image">';
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
