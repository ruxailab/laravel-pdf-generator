{{-- 
    Bar Chart Component (DomPDF Compatible)
    Props: $title, $data (array of ['label' => 'Name', 'value' => count])
--}}
<?php
$total = array_sum(array_column($data, 'value'));
$colors = ['#2ecc71', '#f39c12', '#9b59b6', '#3498db', '#e74c3c', '#1abc9c', '#34495e', '#e67e22'];

// Calculate segments
$segments = [];
foreach ($data as $index => $item) {
    $value = $item['value'];
    $percentage = $total > 0 ? ($value / $total) * 100 : 0;
    
    $segments[] = [
        'label' => $item['label'],
        'value' => $value,
        'percentage' => round($percentage, 1),
        'color' => $colors[$index % count($colors)]
    ];
}
?>

<div class="chart-card">
    <h4 style="text-align: center; margin: 0 0 15px 0; font-size: 11pt; color: #2c3e50;">{{ $title }}</h4>
      
    {{-- Horizontal bars --}}
    <div style="margin: 15px 0;">
        @foreach($segments as $segment)
        <div style="margin: 10px 0;">
            <div style="font-size: 9pt; color: #555; margin-bottom: 3px;">
                {{ $segment['label'] }}: <strong>{{ $segment['value'] }}</strong> ({{ $segment['percentage'] }}%)
            </div>
            <div style="width: 100%; height: 20px; background: #ecf0f1; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ $segment['percentage'] }}%; height: 100%; background: {{ $segment['color'] }}; border-radius: 10px;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
