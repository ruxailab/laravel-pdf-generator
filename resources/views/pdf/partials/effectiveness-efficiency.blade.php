{{-- Effectiveness, Efficiency and Satisfaction Section --}}

<h2>Efectividad, Eficiencia y Satisfacción</h2>

<div style="display: table; width: 100%; margin: 15px 0;">
    {{-- Effectiveness Card --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px;">
            {{-- Icon Circle --}}
            <div style="width: 50px; height: 50px; background: #2ecc71; border-radius: 50%; position: relative; margin: 0 auto 10px auto;">
                <img src="{{ public_path('icons/check-circle-outline.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            
            {{-- Content --}}
            <div style="text-align: center;">
                <div style="font-size: 26pt; font-weight: bold; color: #2ecc71; margin: 0; line-height: 1;">
                    {{ $completionRate }}%
                </div>
                <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                    Effectiveness
                </div>
                <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 8px;">
                    Tasks completed successfully
                </div>
                
                {{-- Progress Bar --}}
                <div style="width: 100%; height: 8px; background: #ecf0f1; border-radius: 4px; overflow: hidden; margin: 0 auto;">
                    <div style="width: {{ $completionRate }}%; height: 100%; background: #2ecc71; border-radius: 4px;"></div>
                </div>
                
                <div style="font-size: 7pt; color: #95a5a6; margin-top: 5px;">
                    {{ $completedTasks }}/{{ $totalTasks }} tasks
                </div>
            </div>
        </div>
    </div>
    
    {{-- Spacer --}}
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Efficiency Card --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px;">
            {{-- Icon Circle --}}
            <div style="width: 50px; height: 50px; background: #3498db; border-radius: 50%; position: relative; margin: 0 auto 10px auto;">
                <img src="{{ public_path('icons/speedometer.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            
            {{-- Content --}}
            <div style="text-align: center;">
                <div style="font-size: 26pt; font-weight: bold; color: #3498db; margin: 0; line-height: 1;">
                    {{ number_format($avgTime / 1000, 1) }}s
                </div>
                <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                    Efficiency
                </div>
                <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 8px;">
                    Average time per task
                </div>
                
                {{-- Metrics Grid --}}
                <div style="padding: 6px; background: #f8f9fa; border-radius: 4px; margin-bottom: 4px;">
                    <div style="font-size: 7pt; color: #7f8c8d;">Total Time</div>
                    <div style="font-size: 9pt; font-weight: bold; color: #2c3e50;">{{ number_format($totalTime / 1000, 1) }}s</div>
                </div>
                <div style="padding: 6px; background: #f8f9fa; border-radius: 4px;">
                    <div style="font-size: 7pt; color: #7f8c8d;">Tasks Measured</div>
                    <div style="font-size: 9pt; font-weight: bold; color: #2c3e50;">{{ $taskCount }}</div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Spacer --}}
    <div style="display: table-cell; width: 2%;"></div>
    
    {{-- Satisfaction Card --}}
    <div style="display: table-cell; width: 32%; vertical-align: top;">
        <div style="padding: 12px 15px; background: white; border: 1px solid #e0e0e0; border-radius: 8px;">
            <?php
            // Calculate satisfaction from NASA-TLX (100 - workload = satisfaction)
            $satisfactionScore = 100 - $overallWorkload;
            $satisfactionColor = $satisfactionScore >= 70 ? '#2ecc71' : ($satisfactionScore >= 50 ? '#f39c12' : '#e74c3c');
            ?>
            {{-- Icon Circle --}}
            <div style="width: 50px; height: 50px; background: {{ $satisfactionColor }}; border-radius: 50%; position: relative; margin: 0 auto 10px auto;">
                <img src="{{ public_path('icons/heart.png') }}" width="28" height="28" style="position: absolute; top: 11px; left: 11px;" />
            </div>
            
            {{-- Content --}}
            <div style="text-align: center;">
                <div style="font-size: 26pt; font-weight: bold; color: {{ $satisfactionColor }}; margin: 0; line-height: 1;">
                    {{ round($satisfactionScore, 1) }}%
                </div>
                <div style="font-size: 11pt; font-weight: bold; color: #2c3e50; margin: 4px 0 5px 0;">
                    Satisfaction
                </div>
                <div style="font-size: 7pt; color: #7f8c8d; margin-bottom: 8px;">
                    Based on NASA-TLX workload
                </div>
                
                {{-- Progress Bar --}}
                <div style="width: 100%; height: 8px; background: #ecf0f1; border-radius: 4px; overflow: hidden; margin: 0 auto;">
                    <div style="width: {{ $satisfactionScore }}%; height: 100%; background: {{ $satisfactionColor }}; border-radius: 4px;"></div>
                </div>
                
                <div style="font-size: 7pt; color: #95a5a6; margin-top: 5px;">
                    Workload: {{ $overallWorkload }}/100
                </div>
            </div>
        </div>
    </div>
</div>
