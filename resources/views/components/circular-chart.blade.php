{{--
    Componente de Gráfico Circular con CSS Puro
    
    Uso:
    @include('components.circular-chart', [
        'data' => [
            ['label' => 'Ventas', 'value' => 35, 'color' => '#3b82f6'],
            ['label' => 'Marketing', 'value' => 25, 'color' => '#10b981'],
            ['label' => 'Desarrollo', 'value' => 40, 'color' => '#f59e0b']
        ],
        'size' => 300,
        'title' => 'Distribución de Presupuesto'
    ])
--}}

@php
    $size = $size ?? 300;
    $title = $title ?? '';
    $data = $data ?? [];
    $total = array_sum(array_column($data, 'value'));
    
    // Calcular los porcentajes y ángulos
    $segments = [];
    $currentAngle = 0;
    
    foreach ($data as $item) {
        $percentage = ($item['value'] / $total) * 100;
        $angle = ($item['value'] / $total) * 360;
        
        $segments[] = [
            'label' => $item['label'],
            'value' => $item['value'],
            'percentage' => round($percentage, 1),
            'color' => $item['color'],
            'startAngle' => $currentAngle,
            'endAngle' => $currentAngle + $angle
        ];
        
        $currentAngle += $angle;
    }
@endphp

<div class="circular-chart-container" style="width: {{ $size }}px;">
    @if($title)
        <h3 class="chart-title">{{ $title }}</h3>
    @endif
    
    <div class="circular-chart" style="width: {{ $size }}px; height: {{ $size }}px;">
        <svg viewBox="0 0 100 100" class="chart-svg">
            @php
                $radius = 40;
                $circumference = 2 * pi() * $radius;
                $offset = 0;
            @endphp
            
            @foreach($segments as $segment)
                @php
                    $strokeDasharray = ($segment['percentage'] / 100) * $circumference;
                    $strokeDashoffset = -$offset;
                    $offset += $strokeDasharray;
                @endphp
                
                <circle
                    class="chart-segment"
                    cx="50"
                    cy="50"
                    r="{{ $radius }}"
                    fill="transparent"
                    stroke="{{ $segment['color'] }}"
                    stroke-width="20"
                    stroke-dasharray="{{ $strokeDasharray }} {{ $circumference }}"
                    stroke-dashoffset="{{ $strokeDashoffset }}"
                    transform="rotate(-90 50 50)"
                    data-label="{{ $segment['label'] }}"
                    data-value="{{ $segment['value'] }}"
                    data-percentage="{{ $segment['percentage'] }}"
                />
            @endforeach
        </svg>
        
        <div class="chart-center">
            <div class="chart-total">{{ $total }}</div>
            <div class="chart-total-label">Total</div>
        </div>
    </div>
    
    <div class="chart-legend">
        @foreach($segments as $segment)
            <div class="legend-item">
                <span class="legend-color" style="background-color: {{ $segment['color'] }}"></span>
                <span class="legend-label">{{ $segment['label'] }}</span>
                <span class="legend-value">{{ $segment['value'] }} ({{ $segment['percentage'] }}%)</span>
            </div>
        @endforeach
    </div>
</div>

<style>
.circular-chart-container {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    margin: 20px auto;
}

.chart-title {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 20px;
}

.circular-chart {
    position: relative;
    margin: 0 auto 30px;
}

.chart-svg {
    width: 100%;
    height: 100%;
    transform: rotate(0deg);
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
}

.chart-segment {
    transition: all 0.3s ease;
    cursor: pointer;
}

.chart-segment:hover {
    opacity: 0.8;
    stroke-width: 22;
}

.chart-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    pointer-events: none;
}

.chart-total {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.chart-total-label {
    font-size: 0.875rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 5px;
}

.chart-legend {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    border-radius: 6px;
    transition: background-color 0.2s ease;
}

.legend-item:hover {
    background-color: #f3f4f6;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 3px;
    flex-shrink: 0;
}

.legend-label {
    flex: 1;
    font-weight: 500;
    color: #374151;
}

.legend-value {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 640px) {
    .chart-title {
        font-size: 1.25rem;
    }
    
    .chart-total {
        font-size: 2rem;
    }
    
    .legend-item {
        font-size: 0.875rem;
    }
}

/* Animación de entrada */
@keyframes drawChart {
    from {
        stroke-dasharray: 0 251.2;
    }
}

.chart-segment {
    animation: drawChart 1s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const segments = document.querySelectorAll('.chart-segment');
    
    segments.forEach(segment => {
        segment.addEventListener('mouseenter', function() {
            const label = this.dataset.label;
            const value = this.dataset.value;
            const percentage = this.dataset.percentage;
            
            // Opcional: Mostrar tooltip
            console.log(`${label}: ${value} (${percentage}%)`);
        });
    });
});
</script>
