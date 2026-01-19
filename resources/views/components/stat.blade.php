@props([
    'stat' => null,
    'label' => '',
    'value' => '',
    'description' => null,
    'descriptionIcon' => null,
    'descriptionColor' => null,
    'icon' => null,
    'iconColor' => null,
    'color' => null,
    'chart' => null,
    'chartColor' => null,
    'url' => null,
    'openUrlInNewTab' => false,
])

@php
    $label = $stat?->getLabel() ?? $label;
    $value = $stat?->getValue() ?? $value;
    $description = $stat?->getDescription() ?? $description;
    $descriptionIcon = $stat?->getDescriptionIcon() ?? $descriptionIcon;
    $descriptionColor = $stat?->getDescriptionColor() ?? $descriptionColor;
    $icon = $stat?->getIcon() ?? $icon;
    $iconColor = $stat?->getIconColor() ?? $iconColor;
    $color = $stat?->getColor() ?? $color;
    $chart = $stat?->getChart() ?? $chart;
    $chartColor = $stat?->getChartColor() ?? $chartColor ?? $color;
    $url = $stat?->getUrl() ?? $url;
    $openUrlInNewTab = $stat?->shouldOpenUrlInNewTab() ?? $openUrlInNewTab;

    // Filament-style ring/accent colors
    $ringColorClasses = match($color) {
        'primary' => 'ring-primary-500/20 dark:ring-primary-400/30',
        'success' => 'ring-emerald-500/20 dark:ring-emerald-400/30',
        'warning' => 'ring-amber-500/20 dark:ring-amber-400/30',
        'danger' => 'ring-rose-500/20 dark:ring-rose-400/30',
        'info' => 'ring-sky-500/20 dark:ring-sky-400/30',
        'gray' => 'ring-gray-500/20 dark:ring-gray-400/30',
        default => 'ring-gray-950/5 dark:ring-white/10',
    };

    // Icon background colors (Filament style)
    $iconBgClasses = match($iconColor ?? $color) {
        'primary' => 'bg-primary-50 text-primary-600 dark:bg-primary-400/10 dark:text-primary-400',
        'success' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-400/10 dark:text-emerald-400',
        'warning' => 'bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-400',
        'danger' => 'bg-rose-50 text-rose-600 dark:bg-rose-400/10 dark:text-rose-400',
        'info' => 'bg-sky-50 text-sky-600 dark:bg-sky-400/10 dark:text-sky-400',
        'gray' => 'bg-gray-50 text-gray-600 dark:bg-gray-400/10 dark:text-gray-400',
        default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
    };

    // Description/trend colors
    $descriptionColorClasses = match($descriptionColor) {
        'success' => 'text-emerald-600 dark:text-emerald-400',
        'danger' => 'text-rose-600 dark:text-rose-400',
        'warning' => 'text-amber-600 dark:text-amber-400',
        'info' => 'text-sky-600 dark:text-sky-400',
        'primary' => 'text-primary-600 dark:text-primary-400',
        default => 'text-gray-500 dark:text-gray-400',
    };

    // Chart gradient colors
    $chartGradientClasses = match($chartColor) {
        'primary' => 'from-primary-500/20 to-transparent',
        'success' => 'from-emerald-500/20 to-transparent',
        'warning' => 'from-amber-500/20 to-transparent',
        'danger' => 'from-rose-500/20 to-transparent',
        'info' => 'from-sky-500/20 to-transparent',
        default => 'from-gray-500/20 to-transparent',
    };

    $chartStrokeClasses = match($chartColor) {
        'primary' => 'stroke-primary-500',
        'success' => 'stroke-emerald-500',
        'warning' => 'stroke-amber-500',
        'danger' => 'stroke-rose-500',
        'info' => 'stroke-sky-500',
        default => 'stroke-gray-500',
    };

    $tag = $url ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($url)
        href="{{ $url }}"
        @if($openUrlInNewTab)
            target="_blank"
            rel="noopener noreferrer"
        @endif
    @endif
    {{ $attributes->class([
        'fi-wi-stats-overview-stat relative rounded-xl bg-white shadow-sm ring-1 dark:bg-gray-900',
        $ringColorClasses,
        'cursor-pointer transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5' => $url,
    ]) }}
>
    {{-- Background Chart (Filament sparkline style) --}}
    @if($chart && is_array($chart) && count($chart) > 1)
        <div class="absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl">
            @php
                $chartData = $chart;
                $min = min($chartData);
                $max = max($chartData);
                $range = $max - $min ?: 1;
                $height = 48;
                $width = 100;
                $points = [];
                $count = count($chartData);
                foreach ($chartData as $i => $val) {
                    $x = ($i / ($count - 1)) * $width;
                    $y = $height - (($val - $min) / $range) * ($height * 0.8);
                    $points[] = "$x,$y";
                }
                $polylinePoints = implode(' ', $points);
                // Create area path
                $areaPath = 'M0,' . $height . ' L' . str_replace(',', ' ', implode(' L', $points)) . ' L' . $width . ',' . $height . ' Z';
            @endphp
            @php $gradientId = 'chart-gradient-' . ($stat?->getId() ?? uniqid()); @endphp
            <svg class="h-12 w-full" viewBox="0 0 {{ $width }} {{ $height }}" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="{{ $gradientId }}" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" class="{{ str_replace('from-', 'stop-color: ', $chartGradientClasses) }}" stop-color="currentColor" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="currentColor" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <path
                    d="{{ $areaPath }}"
                    class="{{ $chartStrokeClasses }}"
                    fill="url(#{{ $gradientId }})"
                    stroke="none"
                />
                <polyline
                    points="{{ $polylinePoints }}"
                    class="{{ $chartStrokeClasses }}"
                    fill="none"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </div>
    @endif

    <div class="relative p-6">
        <div class="flex items-center gap-x-4">
            {{-- Icon (Filament style - rounded background) --}}
            @if($icon)
                <div class="{{ $iconBgClasses }} flex h-12 w-12 shrink-0 items-center justify-center rounded-full">
                    <x-dynamic-component
                        :component="$icon"
                        class="h-6 w-6"
                    />
                </div>
            @endif

            <div class="flex-1 min-w-0">
                {{-- Label --}}
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                    {{ $label }}
                </p>

                {{-- Value --}}
                <p class="mt-1 text-2xl font-semibold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                    {{ $value }}
                </p>

                {{-- Description with trend icon --}}
                @if($description)
                    <p class="mt-1 flex items-center gap-x-1 text-sm font-medium {{ $descriptionColorClasses }}">
                        @if($descriptionIcon)
                            <x-dynamic-component
                                :component="$descriptionIcon"
                                class="h-4 w-4 shrink-0"
                            />
                        @endif
                        <span class="truncate">{{ $description }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</{{ $tag }}>
