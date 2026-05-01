<!DOCTYPE html>
<html>

<style>
    p {
        margin: 0;
        padding: 0;
    }

    /* General Statistics Chart Styles */
    .stats-grid {
        display: table;
        width: 100%;
        margin: 20px 0;
    }

    .stats-row {
        display: table-row;
    }

    .stats-cell {
        display: table-cell;
        vertical-align: middle;
        padding: 10px;
    }

    .usability-gauge {
        text-align: center;
        margin: 20px 0;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .gauge-label {
        font-size: 12pt;
        color: #002D51;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .gauge-container {
        position: relative;
        width: 100%;
        height: 40px;
        background: #e0e0e0;
        border-radius: 20px;
        overflow: hidden;
        margin: 10px 0;
    }

    .gauge-fill {
        height: 100%;
        background: linear-gradient(90deg, #ff425A 0%, #00b894 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 15px;
        color: white;
        font-weight: bold;
        font-size: 14pt;
    }

    .stats-bars {
        margin: 20px 0;
    }

    .stat-bar-item {
        margin: 12px 0;
    }

    .stat-bar-label {
        font-size: 10pt;
        color: #333;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .stat-bar-container {
        position: relative;
        width: 100%;
        height: 30px;
        background: #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
    }

    .stat-bar-fill {
        height: 100%;
        display: flex;
        align-items: center;
        padding-left: 10px;
        color: white;
        font-weight: bold;
        font-size: 10pt;
        border-radius: 5px;
    }

    .stat-bar-max {
        background: #00b894;
    }

    .stat-bar-avg {
        background: #0984e3;
    }

    .stat-bar-min {
        background: #ff7675;
    }

    .stats-summary-box {
        background: #ffffff;
        border: 2px solid #002D51;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }

    .stats-summary-item {
        display: inline-block;
        width: 48%;
        margin: 8px 0;
        font-size: 10pt;
    }

    .stats-summary-label {
        color: #666;
        font-weight: normal;
    }

    .stats-summary-value {
        color: #002D51;
        font-weight: bold;
        font-size: 12pt;
    }

    /* Heatmap Legend */
    .heatmap-legend {
        margin: 10px 0 20px 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        font-size: 9pt;
    }

    .heatmap-legend-title {
        font-weight: bold;
        margin-bottom: 8px;
        color: #002D51;
    }

    .heatmap-legend-gradient {
        height: 20px;
        background: linear-gradient(to right, #ff7675 0%, #ffeaa7 50%, #00b894 100%);
        border-radius: 3px;
        margin: 5px 0;
    }

    .heatmap-legend-labels {
        display: flex;
        justify-content: space-between;
        font-size: 8pt;
        color: #666;
    }
</style>

<body>
    <?php
    // Cálculo das médias
    $totalResults = 0;
    $totalAplication = 0;
    $totalNoAplication = 0;
    $totalAnswered = 0;
    $statisticsItems = $data['statisticsTable']['items'] ?? [];
    $numRows = count($statisticsItems);

    foreach ($statisticsItems as $item) {
        $totalResults += $item['result'] ?? 0;
        $totalAplication += $item['aplication'] ?? 0;
        $totalNoAplication += $item['noAplication'] ?? 0;
        $totalAnswered += $item['answered'] ?? 0;
    }

    $averageResult = $numRows > 0 ? $totalResults / $numRows : 0;
    $averageAplication = $numRows > 0 ? $totalAplication / $numRows : 0;
    $averageNoAplication = $numRows > 0 ? $totalNoAplication / $numRows : 0;
    $averageAnswered = $numRows > 0 ? $totalAnswered / $numRows : 0;

    // Cálculo total de respostas por texto
    $allAnswers = $data['allAnswers'] ?? [];
    $evaluatorCount = count($allAnswers);
    $answerTotals = [];

    foreach ($allAnswers as $evaluatorIndex => $review) {
        $heuristicQuestions = $review['heuristicQuestions'] ?? [];
        foreach ($heuristicQuestions as $heuristicGroup) {
            $questions = $heuristicGroup['heuristicQuestions'] ?? [];
            foreach ($questions as $question) {
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
        
        <p class="section-intro">
            This section presents a comprehensive quantitative analysis of the heuristic evaluation results. 
            It includes usability percentages, answer distribution across evaluators, individual evaluator performance metrics, 
            and detailed breakdowns by both evaluator and heuristic category to identify patterns and areas of concern.
        </p>

        @if(!empty($data['generalStatistics']))
        <div class="section-spacing">
            <h2 id="general-statistics">General statistics</h2>
            
            @php
                $average = floatval(str_replace('%', '', $data['generalStatistics']['average'] ?? '0'));
                $max = floatval(str_replace('%', '', $data['generalStatistics']['max'] ?? '0'));
                $min = floatval(str_replace('%', '', $data['generalStatistics']['min'] ?? '0'));
                $sd = $data['generalStatistics']['sd'] ?? 'N/A';
                $firstItem = $statisticsItems[0] ?? null;
                $totalQuestions = $firstItem ? (($firstItem['aplication'] ?? 0) + ($firstItem['noAplication'] ?? 0)) : 'N/A';
            @endphp

            {{-- Usability Gauge --}}
            <div class="usability-gauge">
                <div class="gauge-label">Overall Usability Percentage</div>
                <div class="gauge-container">
                    <div class="gauge-fill" style="width: {{ $average }}%;">
                        {{ number_format($average, 1) }}%
                    </div>
                </div>
            </div>

            {{-- Comparative Bars --}}
            <div class="stats-bars">
                <div class="stat-bar-item">
                    <div class="stat-bar-label">Maximum Score</div>
                    <div class="stat-bar-container">
                        <div class="stat-bar-fill stat-bar-max" style="width: {{ $max }}%;">
                            {{ number_format($max, 1) }}%
                        </div>
                    </div>
                </div>

                <div class="stat-bar-item">
                    <div class="stat-bar-label">Average Score</div>
                    <div class="stat-bar-container">
                        <div class="stat-bar-fill stat-bar-avg" style="width: {{ $average }}%;">
                            {{ number_format($average, 1) }}%
                        </div>
                    </div>
                </div>

                <div class="stat-bar-item">
                    <div class="stat-bar-label">Minimum Score</div>
                    <div class="stat-bar-container">
                        <div class="stat-bar-fill stat-bar-min" style="width: {{ $min }}%;">
                            {{ number_format($min, 1) }}%
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Box --}}
            <div class="stats-summary-box">
                <div class="stats-summary-item">
                    <span class="stats-summary-label">Standard Deviation: </span>
                    <span class="stats-summary-value">{{ $sd }}</span>
                </div>
                <div class="stats-summary-item">
                    <span class="stats-summary-label">Total Questions: </span>
                    <span class="stats-summary-value">{{ $totalQuestions }}</span>
                </div>
            </div>
        </div>
        @endif

        @if(!empty($answerTotals))
        <div class="section-spacing">
            <h2 id="distribution-answers">Distribution of Answers by Evaluator</h2>
            <table>
                <thead>
                    <tr>
                        <th>Answer</th>
                        @for ($i = 0; $i < count($allAnswers); $i++)
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
        @endif

        @if(!empty($statisticsItems))
        <div class="section-spacing">
            <h2 id="individual-statistics">Individual test statistics</h2>
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
                    @foreach($statisticsItems as $item)
                    <tr>
                        <td>{{ $item['evaluator'] ?? 'N/A' }}</td>
                        <td>{{ $item['result'] ?? 0 }}%</td>
                        <td>{{ $item['aplication'] ?? 0 }}</td>
                        <td>{{ $item['noAplication'] ?? 0 }}</td>
                        <td>{{ $item['answered'] ?? 0 }}%</td>
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
        @endif

        @php
            $statisticsByEvaluator = $data['statisticsByEvaluatorAnswer']['items'] ?? [];
        @endphp
        @if(!empty($statisticsByEvaluator))
        <div class="section-spacing">
            <h2 id="answers-by-evaluator">Answers by Evaluator</h2>
            @php
                // Function to get heatmap color
                function getHeatmapColor($value, $min, $max) {
                    if (is_null($value) || !is_numeric($value)) {
                        return '#ffffff';
                    }
                    
                    $value = floatval($value);
                    
                    // Normalize value between 0 and 1
                    if ($max == $min) {
                        $normalized = 0.5;
                    } else {
                        $normalized = ($value - $min) / ($max - $min);
                    }
                    
                    // Color interpolation: red (0) -> yellow (0.5) -> green (1)
                    if ($normalized < 0.5) {
                        // Red to Yellow
                        $ratio = $normalized * 2;
                        $r = 255;
                        $g = round(100 + (155 * $ratio)); // 100 to 255
                        $b = round(117 - (117 * $ratio)); // 117 to 0
                    } else {
                        // Yellow to Green
                        $ratio = ($normalized - 0.5) * 2;
                        $r = round(255 - (255 * $ratio)); // 255 to 0
                        $g = round(184 + (71 * $ratio)); // 184 to 255
                        $b = round(148 * $ratio); // 0 to 148
                    }
                    
                    return sprintf('#%02x%02x%02x', $r, $g, $b);
                }
                
                // Function to determine text color based on background brightness
                function getTextColor($bgColor) {
                    $r = hexdec(substr($bgColor, 1, 2));
                    $g = hexdec(substr($bgColor, 3, 2));
                    $b = hexdec(substr($bgColor, 5, 2));
                    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
                    return $brightness > 155 ? '#000000' : '#ffffff';
                }
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>Heuristic</th>
                        @php
                        // Pega os nomes das colunas dinâmicas (exceto "heuristic")
                        $evaluators = [];
                        if (!empty($statisticsByEvaluator)) {
                            $firstRow = $statisticsByEvaluator[0];
                            $evaluators = array_keys(array_filter($firstRow, fn($_, $key) => $key !== 'heuristic', ARRAY_FILTER_USE_BOTH));
                        }
                        @endphp
                        @foreach ($evaluators as $ev)
                        <th>{{ $ev }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($statisticsByEvaluator as $row)
                    <tr>
                        <td>{{ $row['heuristic'] ?? 'N/A' }}</td>
                        @php
                            // Calculate min and max for this heuristic (row)
                            $rowValues = [];
                            foreach ($evaluators as $ev) {
                                $val = $row[$ev] ?? null;
                                if (!is_null($val) && is_numeric($val)) {
                                    $rowValues[] = floatval($val);
                                }
                            }
                            $rowMin = !empty($rowValues) ? min($rowValues) : 0;
                            $rowMax = !empty($rowValues) ? max($rowValues) : 100;
                        @endphp
                        @foreach ($evaluators as $ev)
                        @php
                            $cellValue = $row[$ev] ?? null;
                            $bgColor = getHeatmapColor($cellValue, $rowMin, $rowMax);
                            $textColor = getTextColor($bgColor);
                        @endphp
                        <td style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-weight: bold;">
                            {{ is_null($cellValue) ? '—' : number_format($cellValue, 2) }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Heatmap Legend --}}
            <div class="heatmap-legend">
                <div class="heatmap-legend-title">Color Scale (per Heuristic)</div>
                <div class="heatmap-legend-gradient"></div>
                <div class="heatmap-legend-labels">
                    <span>Low (Min)</span>
                    <span>Medium</span>
                    <span>High (Max)</span>
                </div>
                <p style="font-size: 8pt; color: #888; margin-top: 5px; font-style: italic;">
                    Note: Each heuristic row has its own color scale based on its specific min/max values.
                </p>
            </div>
        </div>
        @endif

        @php
            $statisticsByHeuristics = $data['statisticsByHeuristics']['items'] ?? [];
        @endphp
        @if(!empty($statisticsByHeuristics))
        <div class="section-spacing">
            <h2 id="answers-by-heuristics-stats">Answers by Heuristics</h2>
            <table>
                <thead>
                    <tr>
                        <th>Heuristic</th>
                        <th>Standard Deviation</th>
                        <th>Average</th>
                        <th>Max</th>
                        <th>Min</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statisticsByHeuristics as $row)
                    <tr>
                        <td>{{ $row['name'] ?? 'N/A' }}</td>
                        <td>{{ $row['sd'] ?? 'N/A' }}</td>
                        <td>{{ $row['average'] ?? 'N/A' }}</td>
                        <td>{{ $row['max'] ?? 'N/A' }}</td>
                        <td>{{ $row['min'] ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>

</html>