@props(['active' => false, 'disabled' => false])

@php
    $classes = 'inline-flex items-center justify-center px-3 py-2 text-sm font-medium transition rounded-2xl';

    if ($active) {
        $classes .= ' bg-emerald-600 text-white';
    } elseif ($disabled) {
        $classes .= ' text-slate-500 cursor-not-allowed';
    } else {
        $classes .= ' text-slate-300 bg-slate-800 hover:bg-slate-700 hover:text-white';
    }
@endphp

@if($disabled)
    <span {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </span>
@else
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif