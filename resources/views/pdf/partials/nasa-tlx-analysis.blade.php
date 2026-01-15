{{-- NASA-TLX WORKLOAD ANALYSIS --}}
<div class="page-break"></div>
<h2>NASA-TLX Workload Analysis</h2>

<?php
$nasaTlxLabels = [
    'mentalDemand' => 'Mental Demand',
    'physicalDemand' => 'Physical Demand',
    'temporalDemand' => 'Temporal Demand',
    'performance' => 'Performance',
    'effort' => 'Effort',
    'frustration' => 'Frustration'
];

$nasaTlxColors = [
    'mentalDemand' => '#3498db',
    'physicalDemand' => '#2ecc71',
    'temporalDemand' => '#f39c12',
    'performance' => '#9b59b6',
    'effort' => '#e74c3c',
    'frustration' => '#e67e22'
];

// Overall workload (average of all dimensions)
$overallWorkload = count($nasaTlxAvg) > 0 ? round(array_sum($nasaTlxAvg) / count($nasaTlxAvg), 1) : 0;

// Find most and least stressful dimensions
$mostStressful = ['key' => '', 'label' => '', 'value' => 0];
$leastStressful = ['key' => '', 'label' => '', 'value' => 100];
foreach ($nasaTlxAvg as $key => $value) {
    if ($value > $mostStressful['value']) {
        $mostStressful = ['key' => $key, 'label' => $nasaTlxLabels[$key], 'value' => $value];
    }
    if ($value < $leastStressful['value']) {
        $leastStressful = ['key' => $key, 'label' => $nasaTlxLabels[$key], 'value' => $value];
    }
}

$overallColor = $overallWorkload > 70 ? '#e74c3c' : ($overallWorkload > 50 ? '#f39c12' : '#2ecc71');
?>

{{-- Summary Cards --}}
<div style="display: table; width: 100%; margin: 15px 0;">
    {{-- Overall Workload --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; text-align: center;">
            <div style="width: 50px; height: 50px; background: {{ $overallColor }}; border-radius: 50%; position: relative; margin: 0 auto 15px auto;">
                <img src="{{ public_path('icons/brain.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            <div style="font-size: 26pt; font-weight: bold; color: {{ $overallColor }}; margin: 0; line-height: 1;">
                {{ $overallWorkload }}
            </div>
            <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                Overall Workload
            </div>
            <div style="font-size: 7pt; color: #7f8c8d;">
                Average across all dimensions
            </div>
        </div>
    </div>
    
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Most Stressful --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; text-align: center;">
            <div style="width: 50px; height: 50px; background: #e74c3c; border-radius: 50%; position: relative; margin: 0 auto 15px auto;">
                <img src="{{ public_path('icons/alert-circle.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            <div style="font-size: 26pt; font-weight: bold; color: #e74c3c; margin: 0; line-height: 1;">
                {{ $mostStressful['value'] }}
            </div>
            <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                Most Stressful
            </div>
            <div style="font-size: 7pt; color: #7f8c8d;">
                {{ $mostStressful['label'] }}
            </div>
        </div>
    </div>
    
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Least Stressful --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; text-align: center;">
            <div style="width: 50px; height: 50px; background: #2ecc71; border-radius: 50%; position: relative; margin: 0 auto 15px auto;">
                <img src="{{ public_path('icons/target-account.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            <div style="font-size: 26pt; font-weight: bold; color: #2ecc71; margin: 0; line-height: 1;">
                {{ $leastStressful['value'] }}
            </div>
            <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                Least Stressful
            </div>
            <div style="font-size: 7pt; color: #7f8c8d;">
                {{ $leastStressful['label'] }}
            </div>
        </div>
    </div>
</div>

{{-- Dimension Comparison Bar Chart --}}
<div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; border: 1px solid #e0e0e0;">
    <h3 style="color: #2c3e50; margin: 0 0 15px 0; font-size: 12pt;">Dimension Comparison</h3>
    
    <div class="bar-chart">
        @foreach($nasaTlxLabels as $key => $label)
        <?php
            $value = $nasaTlxAvg[$key] ?? 0;
            $percentage = $value;
            $class = $percentage > 70 ? 'danger' : ($percentage > 50 ? 'warning' : 'success');
            $color = $nasaTlxColors[$key];
        ?>
        <div class="bar-row">
            <div class="bar-label">{{ $label }}</div>
            <div class="bar-container">
                <div class="bar-fill" style="width: {{ $percentage }}%; background: {{ $color }};"></div>
            </div>
            <div class="bar-value">{{ $value }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Individual TLX Scores Table --}}
<h3 style="color: #2c3e50; margin: 20px 0 10px 0; font-size: 12pt;">Individual NASA-TLX Scores</h3>

<?php
// Build table data: each row is a task response, columns are dimensions
$tlxTableData = [];
$userCounter = 1;

foreach ($taskAnswers as $userIndex => $user) {
    if (!empty($user['tasks'])) {
        foreach ($user['tasks'] as $taskIndex => $task) {
            if (!empty($task['nasaTlxAnswers'])) {
                $row = [
                    'user' => $userCounter,
                    'task' => (int)$taskIndex + 1
                ];
                foreach (array_keys($nasaTlxLabels) as $dimension) {
                    $row[$dimension] = $task['nasaTlxAnswers'][$dimension] ?? '-';
                }
                $tlxTableData[] = $row;
            }
        }
    }
    $userCounter++;
}
?>

@if(count($tlxTableData) > 0)
<table style="font-size: 8pt;">
    <thead>
        <tr>
            <th style="width: 8%;">User</th>
            <th style="width: 8%;">Task</th>
            @foreach($nasaTlxLabels as $key => $label)
            <th style="width: 14%;">{{ $label }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($tlxTableData as $row)
        <tr>
            <td style="text-align: center; font-weight: bold;">{{ $row['user'] }}</td>
            <td style="text-align: center; font-weight: bold;">{{ $row['task'] }}</td>
            @foreach(array_keys($nasaTlxLabels) as $dimension)
            <?php
                $value = $row[$dimension];
                if ($value !== '-' && is_numeric($value)) {
                    // Escala de color: rojo (bajo) -> amarillo (medio) -> verde (alto)
                    if ($value < 33) {
                        $chipColor = '#e74c3c'; // Rojo para valores bajos
                    } elseif ($value < 67) {
                        $chipColor = '#f39c12'; // Naranja para valores medios
                    } else {
                        $chipColor = '#2ecc71'; // Verde para valores altos
                    }
                } else {
                    $chipColor = '#95a5a6'; // Gris para valores no disponibles
                }
            ?>
            <td style="text-align: center;">
                <span style="display: inline-block; padding: 3px 8px; background: {{ $chipColor }}; color: white; border-radius: 12px; font-weight: bold; font-size: 8pt;">{{ $value }}</span>
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 15px; padding: 10px; background: white; border-radius: 5px; border: 1px solid #e0e0e0;">
    <h4 style="margin: 0 0 10px 0; color: #555; font-size: 10pt;">Interpretation</h4>
    <p style="font-size: 9pt; margin: 5px 0; line-height: 1.5;">
        @if($overallWorkload < 40)
            <strong style="color: #2ecc71;">Low Workload:</strong> The system demonstrates good usability with minimal cognitive load.
        @elseif($overallWorkload < 60)
            <strong style="color: #3498db;">Moderate Workload:</strong> The system is acceptable but has room for usability improvements.
        @elseif($overallWorkload < 80)
            <strong style="color: #f39c12;">High Workload:</strong> Users experienced significant cognitive load. Consider redesigning complex tasks.
        @else
            <strong style="color: #e74c3c;">Very High Workload:</strong> The system presents serious usability challenges requiring immediate attention.
        @endif
    </p>
</div>
@else
<p style="font-size: 9pt; color: #7f8c8d; text-align: center; padding: 20px;">No individual NASA-TLX scores available.</p>
@endif
