@props(['framework' => 'vanilla', 'prefix' => 'a', 'documentation' => null, 'hasDemo' => true])

@php
    app('accelade')->setFramework($framework);
@endphp

<x-accelade::layouts.docs :framework="$framework" section="widgets" :documentation="$documentation" :hasDemo="$hasDemo">
    @include('widgets::demo.partials._widgets', ['prefix' => $prefix])
</x-accelade::layouts.docs>
