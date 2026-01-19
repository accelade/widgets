@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

@php
    app('accelade')->setFramework($framework);
@endphp

<x-accelade::layouts.docs :framework="$framework" section="stats-widget" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('widgets::demo.partials._stats-widget', ['prefix' => $prefix])
</x-accelade::layouts.docs>
