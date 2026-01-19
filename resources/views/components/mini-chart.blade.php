@props([
    'data' => [],
    'color' => 'primary',
])

@php
    $chartId = 'mini-chart-' . uniqid();
    $strokeColor = match($color) {
        'success' => '#22c55e',
        'warning' => '#f59e0b',
        'danger' => '#ef4444',
        'info' => '#06b6d4',
        default => '#3b82f6',
    };
@endphp

<div
    id="{{ $chartId }}"
    class="mini-chart h-full w-full"
    data-mini-chart="{{ json_encode($data) }}"
    data-mini-chart-color="{{ $strokeColor }}"
>
    {{-- SVG will be rendered by JavaScript --}}
    @if(count($data) > 0)
        @php
            $max = max($data);
            $min = min($data);
            $range = $max - $min ?: 1;
            $width = 100;
            $height = 40;
            $points = [];

            foreach ($data as $i => $value) {
                $x = ($i / (count($data) - 1)) * $width;
                $y = $height - (($value - $min) / $range) * $height;
                $points[] = "{$x},{$y}";
            }

            $pathData = 'M ' . implode(' L ', $points);
        @endphp
        <svg viewBox="0 0 {{ $width }} {{ $height }}" preserveAspectRatio="none" class="h-full w-full">
            <path
                d="{{ $pathData }}"
                fill="none"
                stroke="{{ $strokeColor }}"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    @endif
</div>
