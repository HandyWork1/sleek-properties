@props(['row', 'col'])

@php
    $location = $row->location;
@endphp

@if ($location)
<div class="text-sm leading-tight">
    <div class="font-medium text-gray-900 dark:text-gray-100">
        {{ $location->name }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
        {{ $location->country->name ?? '—' }}
    </div>
</div>
@else
<div class="text-sm text-gray-400 dark:text-gray-500">—</div>
@endif

