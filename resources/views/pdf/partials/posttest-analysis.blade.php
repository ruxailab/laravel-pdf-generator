{{-- POST-TEST ANALYSIS --}}
<?php
// Aggregate post-test responses
$postTestAggregated = [];
foreach ($taskAnswers as $user) {
    if (!empty($user['postTestAnswer'])) {
        foreach ($user['postTestAnswer'] as $answer) {
            $title = $answer['title'] ?? 'Sin título';
            $response = $answer['answer'] ?? '';
            
            if (!isset($postTestAggregated[$title])) {
                $postTestAggregated[$title] = [];
            }
            
            if (!empty($response)) {
                $postTestAggregated[$title][] = $response;
            }
        }
    }
}
?>

@if(!empty($postTestAggregated))
<div class="page-break"></div>
<h2>Post-Test Analysis</h2>

<div style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; border: 1px solid #e0e0e0;">
    @foreach($postTestAggregated as $question => $answers)
    <div style="margin-bottom: 20px;">
        <h4 style="color: #2c3e50; margin: 0 0 10px 0;">{{ $question }}</h4>
        <table style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr>
                    <th style="background: #34495e; color: white; padding: 8px; text-align: left; font-size: 9pt; width: 15%;">Participante</th>
                    <th style="background: #34495e; color: white; padding: 8px; text-align: left; font-size: 9pt;">Respuesta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($answers as $index => $answer)
                <tr style="{{ $index % 2 == 0 ? 'background: #f9f9f9;' : 'background: white;' }}">
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 9pt;">P{{ $index + 1 }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; font-size: 9pt;">{{ $answer }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</div>
@endif
