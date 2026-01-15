{{-- Pre-Test Analysis with Charts --}}
<?php
// Aggregate pre-test answers
$preTestAggregated = [];
$preTestRespondents = 0;

foreach ($taskAnswers as $user) {
    if (!empty($user['preTestAnswer'])) {
        $preTestRespondents++;
        foreach ($user['preTestAnswer'] as $index => $answerData) {
            $answer = $answerData['answer'] ?? null;
            if ($answer) {
                if (!isset($preTestAggregated[$index])) {
                    $preTestAggregated[$index] = [];
                }
                if (!isset($preTestAggregated[$index][$answer])) {
                    $preTestAggregated[$index][$answer] = 0;
                }
                $preTestAggregated[$index][$answer]++;
            }
        }
    }
}

// Question labels
$preTestQuestions = [
    0 => 'Rango de Edad',
    1 => 'Género',
    2 => 'Experiencia Previa',
    3 => 'Nivel de Familiaridad'
];
?>

@if(!empty($preTestAggregated))
<div class="page-break"></div>
<h2>Análisis de Respuestas Pre-Test ({{ $preTestRespondents }}/{{ $totalUsers }} usuarios)</h2>

<div class="chart-cards-grid">
    @foreach($preTestAggregated as $questionIndex => $answers)
        <?php
        $questionLabel = $preTestQuestions[$questionIndex] ?? "Pregunta " . ($questionIndex + 1);
        
        // Prepare data for pie chart
        $chartData = [];
        foreach ($answers as $answer => $count) {
            $chartData[] = ['label' => $answer, 'value' => $count];
        }
        ?>
        
        @include('pdf.partials.pie-chart', [
            'title' => $questionLabel,
            'data' => $chartData
        ])
        
        @if(($questionIndex + 1) % 2 == 0 && ($questionIndex + 1) < count($preTestAggregated))
            </div><div class="chart-cards-grid">
        @endif
    @endforeach
</div>
@endif
