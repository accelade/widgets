@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

@php
    app('accelade')->setFramework($framework);
@endphp

<x-accelade::layouts.docs :framework="$framework" section="chart-widget" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('widgets::demo.partials._chart-widget', ['prefix' => $prefix])
</x-accelade::layouts.docs>
