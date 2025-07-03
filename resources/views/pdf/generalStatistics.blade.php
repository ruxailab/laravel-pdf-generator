<!DOCTYPE html>
<html>

<style> 

    p {
        margin: 0;
        padding: 0;
    }
</style>

<body>
    <?php
    // Cálculo das médias
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

    // Cálculo total de respostas por texto
    $evaluatorCount = count($data['allAnswers']);
    $answerTotals = [];

    foreach ($data['allAnswers'] as $evaluatorIndex => $review) {
        foreach ($review['heuristicQuestions'] as $heuristicGroup) {
            foreach ($heuristicGroup['heuristicQuestions'] as $question) {
                $text = $question['heuristicAnswer']['text'] ?? null;
                if ($text !== null) {
                    if (!isset($answerTotals[$text])) {
                        $answerTotals[$text] = array_fill(0, $evaluatorCount, 0);
                    }
                    $answerTotals[$text][$evaluatorIndex]++;
                }
            }
        }
    }
    ?>

    <div id="statistics" class="page-section">
        <h1>Statistics</h1>

        <div class="section-spacing">
            <h2>General statistics</h2>
            <p><strong>Usability percentage:</strong> {{ $data['generalStatistics']['average'] }}</p>
            <p><strong>Max:</strong> {{ $data['generalStatistics']['max'] }}</p>
            <p><strong>Min:<strong> {{ $data['generalStatistics']['min'] }}</p>
            <p><strong>Standard Deviation:</strong> {{ $data['generalStatistics']['sd'] }}</p>
            <p><strong>Total test questions(s):</strong> {{ $data['statisticsTable']['items'][0]['aplication'] + $data['statisticsTable']['items'][0]['noAplication'] }}</p>
        </div>

        <div class="section-spacing">
            <h2>Distribution of Answers by Evaluator</h2>
            <table>
                <thead>
                    <tr>
                        <th>Answer</th>
                        @for ($i = 0; $i < count($data['allAnswers']); $i++)
                            <th>Ev{{ $i + 1 }}</th>
                        @endfor
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answerTotals as $answer => $counts)
                    <tr>
                        <td>{{ $answer }}</td>
                        @foreach ($counts as $count)
                            <td>{{ $count }}</td>
                        @endforeach
                        <td>{{ array_sum($counts) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section-spacing">
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
                        <td>{{ $item['evaluator'] }}</td>
                        <td>{{ $item['result'] }}%</td>
                        <td>{{ $item['aplication'] }}</td>
                        <td>{{ $item['noAplication'] }}</td>
                        <td>{{ $item['answered'] }}%</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="text-align: center;"><strong>Average</strong></td>
                        <td>{{ number_format($averageResult, 2) }}%</td>
                        <td>{{ number_format($averageAplication, 2) }}</td>
                        <td>{{ number_format($averageNoAplication, 2) }}</td>
                        <td>{{ number_format($averageAnswered, 2) }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section-spacing">
            <h2>Answers by Evaluator</h2>
            <table>
                <thead>
                    <tr>
                        <th>Heuristic</th>
                        <th>Ev1</th>
                        <th>Ev2</th>
                        <th>Ev3</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['statisticsByEvaluatorAnswer']['items'] as $row)
                    <tr>
                        <td>{{ $row['heuristic'] }}</td>
                        <td>{{ is_null($row['Ev1']) ? '—' : number_format($row['Ev1'], 2) }}</td>
                        <td>{{ is_null($row['Ev2']) ? '—' : number_format($row['Ev2'], 2) }}</td>
                        <td>{{ is_null($row['Ev3']) ? '—' : number_format($row['Ev3'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section-spacing">
            <h2>Answers by Heuristics</h2>
            <table>
                <thead>
                    <tr>
                        <th>Heuristic</th>
                        <th>Percentage (%)</th>
                        <th>Standard Deviation</th>
                        <th>Average</th>
                        <th>Max</th>
                        <th>Min</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['statisticsByHeuristics']['items'] as $row)
                    <tr>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['percentage'] }}</td>
                        <td>{{ $row['sd'] }}</td>
                        <td>{{ $row['average'] }}</td>
                        <td>{{ $row['max'] }}</td>
                        <td>{{ $row['min'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
