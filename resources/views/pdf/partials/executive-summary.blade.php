{{-- Executive Summary - One Pager Style --}}

<?php
// Calculate dates for header
$firstDate = null;
$lastDate = null;
foreach ($taskAnswers as $user) {
    if (!empty($user['lastUpdate'])) {
        $timestamp = $user['lastUpdate'];
        if ($firstDate === null || $timestamp < $firstDate) $firstDate = $timestamp;
        if ($lastDate === null || $timestamp > $lastDate) $lastDate = $timestamp;
    }
}
$firstDateFormatted = $firstDate ? date('d/m/Y', $firstDate / 1000) : '-';
$lastDateFormatted = $lastDate ? date('d/m/Y', $lastDate / 1000) : '-';

// Calculate unique tasks
$taskIds = [];
foreach ($taskAnswers as $user) {
    if (!empty($user['tasks'])) {
        foreach ($user['tasks'] as $task) {
            $taskId = $task['taskId'] ?? null;
            if ($taskId !== null && !in_array($taskId, $taskIds)) $taskIds[] = $taskId;
        }
    }
}
$uniqueTasks = count($taskIds);

// Satisfaction score
$satisfactionScore = 100 - $overallWorkload;
$satisfactionColor = $satisfactionScore >= 70 ? '#2ecc71' : ($satisfactionScore >= 50 ? '#f39c12' : '#e74c3c');
?>

{{-- Compact Header --}}
<div style="background: #f8f9fa; padding: 10px 15px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #ff425A;">
    <div style="display: table; width: 100%;">
        <div style="display: table-cell; width: 70%; vertical-align: middle;">
            <div style="font-size: 9pt; color: #7f8c8d; margin-bottom: 2px;">Test Period</div>
            <div style="font-size: 8pt; color: #2c3e50;"><strong>{{ $firstDateFormatted }}</strong> → <strong>{{ $lastDateFormatted }}</strong></div>
        </div>
        <div style="display: table-cell; width: 30%; vertical-align: middle; text-align: right;">
            <div style="font-size: 9pt; color: #7f8c8d; margin-bottom: 2px;">Completion Rate</div>
            <div style="font-size: 11pt; color: #2ecc71; font-weight: bold;">{{ $submissionRate }}%</div>
        </div>
    </div>
</div>

{{-- Quick Stats Row --}}
<div style="display: table; width: 100%; margin-bottom: 12px;">
    <div style="display: table-cell; width: 24%; padding: 8px; background: #ecf0f1; border-radius: 5px; text-align: center;">
        <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 3px;">PARTICIPANTS</div>
        <div style="font-size: 16pt; font-weight: bold; color: #2c3e50;">{{ $totalUsers }}</div>
        <div style="font-size: 6pt; color: #95a5a6;">{{ $submittedUsers }} completed</div>
    </div>
    <div style="display: table-cell; width: 1%;"></div>
    <div style="display: table-cell; width: 24%; padding: 8px; background: #ecf0f1; border-radius: 5px; text-align: center;">
        <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 3px;">TASKS</div>
        <div style="font-size: 16pt; font-weight: bold; color: #2c3e50;">{{ $uniqueTasks }}</div>
        <div style="font-size: 6pt; color: #95a5a6;">{{ $totalTasks }} total attempts</div>
    </div>
    <div style="display: table-cell; width: 1%;"></div>
    <div style="display: table-cell; width: 24%; padding: 8px; background: #ecf0f1; border-radius: 5px; text-align: center;">
        <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 3px;">SUCCESS RATE</div>
        <div style="font-size: 16pt; font-weight: bold; color: #2ecc71;">{{ $completionRate }}%</div>
        <div style="font-size: 6pt; color: #95a5a6;">{{ $completedTasks }}/{{ $totalTasks }}</div>
    </div>
    <div style="display: table-cell; width: 1%;"></div>
    <div style="display: table-cell; width: 24%; padding: 8px; background: #ecf0f1; border-radius: 5px; text-align: center;">
        <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 3px;">AVG TIME</div>
        <div style="font-size: 16pt; font-weight: bold; color: #3498db;">{{ number_format($avgTime / 1000, 1) }}s</div>
        <div style="font-size: 6pt; color: #95a5a6;">per task</div>
    </div>
</div>

{{-- Main Metrics - 2 Rows of Cards --}}
<h3 style="font-size: 11pt; color: #2c3e50; margin: 12px 0 8px 0; border-bottom: 2px solid #e0e0e0; padding-bottom: 5px;">Key Performance Indicators</h3>

<div style="display: table; width: 100%; margin-bottom: 10px;">
    {{-- Effectiveness --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 10px 12px; background: white; border: 1px solid #e0e0e0; border-radius: 6px;">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 35px; vertical-align: middle;">
                    <div style="width: 35px; height: 35px; background: #2ecc71; border-radius: 50%; position: relative;">
                        <img src="{{ public_path('icons/check-circle-outline.png') }}" width="20" height="20" style="position: absolute; top: 7.5px; left: 7.5px;" />
                    </div>
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
                    <div style="font-size: 20pt; font-weight: bold; color: #2ecc71; line-height: 1;">{{ $completionRate }}%</div>
                    <div style="font-size: 9pt; font-weight: bold; color: #2c3e50; margin-top: 2px;">Effectiveness</div>
                </div>
            </div>
            <div style="width: 100%; height: 6px; background: #ecf0f1; border-radius: 3px; overflow: hidden; margin-top: 8px;">
                <div style="width: {{ $completionRate }}%; height: 100%; background: #2ecc71;"></div>
            </div>
        </div>
    </div>
    
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Efficiency --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 10px 12px; background: white; border: 1px solid #e0e0e0; border-radius: 6px;">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 35px; vertical-align: middle;">
                    <div style="width: 35px; height: 35px; background: #3498db; border-radius: 50%; position: relative;">
                        <img src="{{ public_path('icons/speedometer.png') }}" width="20" height="20" style="position: absolute; top: 7.5px; left: 7.5px;" />
                    </div>
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
                    <div style="font-size: 20pt; font-weight: bold; color: #3498db; line-height: 1;">{{ number_format($avgTime / 1000, 1) }}s</div>
                    <div style="font-size: 9pt; font-weight: bold; color: #2c3e50; margin-top: 2px;">Efficiency</div>
                </div>
            </div>
            <div style="font-size: 7pt; color: #7f8c8d; margin-top: 8px; text-align: center;">
                Total: {{ number_format($totalTime / 1000, 1) }}s • {{ $taskCount }} tasks
            </div>
        </div>
    </div>
    
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Satisfaction --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 10px 12px; background: white; border: 1px solid #e0e0e0; border-radius: 6px;">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 35px; vertical-align: middle;">
                    <div style="width: 35px; height: 35px; background: {{ $satisfactionColor }}; border-radius: 50%; position: relative;">
                        <img src="{{ public_path('icons/heart.png') }}" width="20" height="20" style="position: absolute; top: 7.5px; left: 7.5px;" />
                    </div>
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 10px;">
                    <div style="font-size: 20pt; font-weight: bold; color: {{ $satisfactionColor }}; line-height: 1;">{{ round($satisfactionScore, 1) }}%</div>
                    <div style="font-size: 9pt; font-weight: bold; color: #2c3e50; margin-top: 2px;">Satisfaction</div>
                </div>
            </div>
            <div style="width: 100%; height: 6px; background: #ecf0f1; border-radius: 3px; overflow: hidden; margin-top: 8px;">
                <div style="width: {{ $satisfactionScore }}%; height: 100%; background: {{ $satisfactionColor }};"></div>
            </div>
        </div>
    </div>
</div>

{{-- NASA-TLX Summary (if available) --}}
@if(!empty($nasaTlxAvg) && array_sum($nasaTlxAvg) > 0)
<?php
// Calculate per-task statistics
$taskStats = [];
foreach ($taskAnswers as $user) {
    if (!empty($user['tasks'])) {
        foreach ($user['tasks'] as $task) {
            $taskId = $task['taskId'] ?? null;
            if ($taskId !== null) {
                if (!isset($taskStats[$taskId])) {
                    $taskStats[$taskId] = [
                        'times' => [],
                        'completed' => 0,
                        'total' => 0
                    ];
                }
                $taskStats[$taskId]['total']++;
                if (!empty($task['completed'])) {
                    $taskStats[$taskId]['completed']++;
                }
                if (!empty($task['taskTime'])) {
                    $taskStats[$taskId]['times'][] = $task['taskTime'];
                }
            }
        }
    }
}

// Sort tasks by ID and limit to first 3 tasks
ksort($taskStats);
$taskStats = array_slice($taskStats, 0, 3, true);

// Calculate metrics for each task
$taskMetrics = [];
foreach ($taskStats as $taskId => $stats) {
    $avgTime = !empty($stats['times']) ? array_sum($stats['times']) / count($stats['times']) : 0;
    $effectiveness = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100, 1) : 0;
    $taskMetrics[] = [
        'id' => $taskId,
        'avgTime' => $avgTime,
        'effectiveness' => $effectiveness,
        'color' => $effectiveness >= 70 ? '#2ecc71' : ($effectiveness >= 50 ? '#f39c12' : '#e74c3c')
    ];
}
?>

<div style="display: table; width: 100%; margin-top: 10px;">
    @foreach($taskMetrics as $index => $task)
    @if($index > 0)
    <div style="display: table-cell; width: 2%;"></div>
    @endif
    
    {{-- Task Card --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 10px 12px; background: white; border: 1px solid #e0e0e0; border-radius: 6px;">
            <div style="font-size: 8pt; font-weight: bold; color: #3498db; margin-bottom: 8px; text-align: center; background: #ecf0f1; padding: 4px; border-radius: 3px;">
                TASK {{ $index + 1 }}
            </div>
            
            {{-- Avg Time --}}
            <div style="display: table; width: 100%; margin-bottom: 8px;">
                <div style="display: table-cell; width: 30px; vertical-align: middle;">
                    <div style="width: 30px; height: 30px; background: #3498db; border-radius: 50%; position: relative;">
                        <img src="{{ public_path('icons/clock-fast.png') }}" width="18" height="18" style="position: absolute; top: 6px; left: 6px;" />
                    </div>
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 8px;">
                    <div style="font-size: 16pt; font-weight: bold; color: #3498db; line-height: 1;">{{ number_format($task['avgTime'] / 1000, 1) }}s</div>
                    <div style="font-size: 7pt; color: #7f8c8d; margin-top: 1px;">Avg Time</div>
                </div>
            </div>
            
            {{-- Effectiveness --}}
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 30px; vertical-align: middle;">
                    <div style="width: 30px; height: 30px; background: {{ $task['color'] }}; border-radius: 50%; position: relative;">
                        <img src="{{ public_path('icons/check-circle-outline.png') }}" width="18" height="18" style="position: absolute; top: 6px; left: 6px;" />
                    </div>
                </div>
                <div style="display: table-cell; vertical-align: middle; padding-left: 8px;">
                    <div style="font-size: 16pt; font-weight: bold; color: {{ $task['color'] }}; line-height: 1;">{{ $task['effectiveness'] }}%</div>
                    <div style="font-size: 7pt; color: #7f8c8d; margin-top: 1px;">Effectiveness</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
