{{-- USER DETAILS --}}
<h2>Individual User Details</h2>

@foreach($taskAnswers as $userId => $user)
<div style="margin: 20px 0; padding: 15px; background: white; border: 1px solid #e0e0e0; border-radius: 5px;">
    <h3 style="color: #2c3e50; margin: 0 0 10px 0;">
        {{ $user['fullName'] ?? 'Anonymous User' }}
        @if(!empty($user['submitted']))
            <span class="badge badge-success">Submitted</span>
        @else
            <span class="badge badge-warning">Not Submitted</span>
        @endif
    </h3>
    
    <p style="font-size: 9pt; color: #666; margin: 0 0 15px 0;">User ID: {{ $userId }}</p>
    
    @if(!empty($user['tasks']))
    <h4>Task Performance</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Task ID</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 20%;">Time</th>
                <th style="width: 50%;">Observations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user['tasks'] as $task)
            <tr>
                <td>{{ $task['taskId'] ?? '-' }}</td>
                <td>
                    @if(!empty($task['completed']))
                        <span class="badge badge-success">Completed</span>
                    @elseif(!empty($task['attempted']))
                        <span class="badge badge-warning">Attempted</span>
                    @else
                        <span class="badge badge-danger">Not Started</span>
                    @endif
                </td>
                <td>
                    @if(!empty($task['taskTime']))
                        {{ round($task['taskTime'] / 1000, 1) }}s
                    @else
                        -
                    @endif
                </td>
                <td style="font-size: 8pt;">{{ $task['taskObservations'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- NASA-TLX per user if available --}}
    @php
        $userNasaTlx = [];
        foreach($user['tasks'] as $task) {
            if(!empty($task['nasaTlxAnswers'])) {
                foreach($task['nasaTlxAnswers'] as $key => $value) {
                    if(!isset($userNasaTlx[$key])) $userNasaTlx[$key] = [];
                    if(is_numeric($value)) $userNasaTlx[$key][] = $value;
                }
            }
        }
        $userHasNasaTlx = !empty($userNasaTlx);
    @endphp
    
    @if($userHasNasaTlx)
    <h4 style="margin-top: 15px;">NASA-TLX Scores</h4>
    <div style="display: table; width: 100%;">
        @foreach($userNasaTlx as $key => $values)
        <?php
            $avg = count($values) > 0 ? round(array_sum($values) / count($values), 1) : 0;
            $label = ucwords(str_replace(['Demand', 'Tlx'], ['', ''], preg_replace('/([A-Z])/', ' $1', $key)));
        ?>
        <div style="display: table-cell; width: 16%; padding: 5px; text-align: center;">
            <div style="background: #ecf0f1; padding: 8px; border-radius: 5px;">
                <div style="font-size: 8pt; color: #7f8c8d; margin-bottom: 3px;">{{ trim($label) }}</div>
                <div style="font-size: 12pt; font-weight: bold; color: #2c3e50;">{{ $avg }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    {{-- Media recordings if available --}}
    @php
        $hasMedia = false;
        foreach($user['tasks'] as $task) {
            if(!empty($task['audioRecordURL']) || !empty($task['screenRecordURL']) || !empty($task['webcamRecordURL'])) {
                $hasMedia = true;
                break;
            }
        }
    @endphp
    
    @if($hasMedia)
    <h4 style="margin-top: 15px;">Recordings</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Task</th>
                <th style="width: 28%;">Audio</th>
                <th style="width: 28%;">Screen</th>
                <th style="width: 28%;">Webcam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user['tasks'] as $task)
            @if(!empty($task['audioRecordURL']) || !empty($task['screenRecordURL']) || !empty($task['webcamRecordURL']))
            <tr>
                <td>{{ $task['taskId'] ?? '-' }}</td>
                <td style="font-size: 7pt; word-break: break-all;">
                    @if(!empty($task['audioRecordURL']))
                        <a href="file://{{ storage_path('app/' . $task['audioRecordURL']) }}" style="color: #002D51; text-decoration: underline;">Audio</a>
                    @else
                        -
                    @endif
                </td>
                <td style="font-size: 7pt; word-break: break-all;">
                    @if(!empty($task['screenRecordURL']))
                        <a href="file://{{ storage_path('app/' . $task['screenRecordURL']) }}" style="color: #002D51; text-decoration: underline;">Screen</a>
                    @else
                        -
                    @endif
                </td>
                <td style="font-size: 7pt; word-break: break-all;">
                    @if(!empty($task['webcamRecordURL']))
                        <a href="file://{{ storage_path('app/' . $task['webcamRecordURL']) }}" style="color: #002D51; text-decoration: underline;">Webcam</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endif
    
    {{-- Facial Sentiment Analysis if available --}}
    @php
        $hasFacialSentiment = false;
        foreach($user['tasks'] as $task) {
            if(!empty($task['facialSentimentResults'])) {
                $hasFacialSentiment = true;
                break;
            }
        }
    @endphp
    
    @if($hasFacialSentiment)
    <h4 style="margin-top: 15px;">Facial Sentiment Analysis</h4>
    
    <div style="display: table; width: 100%; margin-top: 10px;">
        @foreach($user['tasks'] as $taskIndex => $task)
        @if(!empty($task['facialSentimentResults']))
        <?php
            $sentiments = is_string($task['facialSentimentResults']) 
                ? json_decode($task['facialSentimentResults'], true) 
                : $task['facialSentimentResults'];
            
            $chartData = [];
            
            if (is_array($sentiments)) {
                // Extract emotion data for chart
                if (isset($sentiments['emotions']) && is_array($sentiments['emotions'])) {
                    foreach ($sentiments['emotions'] as $emotion => $value) {
                        if (is_numeric($value)) {
                            $chartData[] = ['label' => ucfirst($emotion), 'value' => round($value, 1)];
                        }
                    }
                } else {
                    // Simple key-value pairs
                    foreach ($sentiments as $key => $value) {
                        if (is_numeric($value)) {
                            $chartData[] = ['label' => ucfirst($key), 'value' => round($value, 1)];
                        }
                    }
                }
            }
            
            // Colors for emotions
            $emotionColors = ['#2ecc71', '#f39c12', '#9b59b6', '#3498db', '#e74c3c', '#1abc9c', '#34495e', '#e67e22'];
            $total = array_sum(array_column($chartData, 'value'));
        ?>
        
        @if(!empty($chartData))
        <div style="display: table-cell; width: {{ 100 / count(array_filter($user['tasks'], function($t) { return !empty($t['facialSentimentResults']); })) }}%; padding: 10px; vertical-align: top;">
            <div style="background: #f8f9fa; padding: 12px; border-radius: 5px; border: 1px solid #e0e0e0;">
                <h5 style="text-align: center; margin: 0 0 10px 0; font-size: 10pt; color: #2c3e50;">Task {{ $task['taskId'] ?? ($taskIndex + 1) }}</h5>
                
                {{-- Horizontal bars showing emotion percentages --}}
                <div style="margin: 8px 0;">
                    @foreach($chartData as $index => $emotion)
                    <?php
                        $percentage = $total > 0 ? ($emotion['value'] / $total) * 100 : 0;
                        $color = $emotionColors[$index % count($emotionColors)];
                    ?>
                    <div style="margin: 6px 0;">
                        <div style="font-size: 8pt; color: #555; margin-bottom: 2px;">
                            {{ $emotion['label'] }}: <strong>{{ $emotion['value'] }}%</strong>
                        </div>
                        <div style="width: 100%; height: 15px; background: #ecf0f1; border-radius: 8px; overflow: hidden;">
                            <div style="width: {{ $percentage }}%; height: 100%; background: {{ $color }}; border-radius: 8px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(isset($sentiments['dominant_emotion']))
                <div style="text-align: center; margin-top: 8px; padding: 5px; background: #002D51; color: white; border-radius: 4px; font-size: 8pt;">
                    <strong>Dominant:</strong> {{ ucfirst($sentiments['dominant_emotion']) }}
                </div>
                @endif
            </div>
        </div>
        @endif
        
        @endif
        @endforeach
    </div>
    @endif
    
    @endif
</div>

@if(!$loop->last)
<div class="page-break"></div>
@endif

@endforeach
