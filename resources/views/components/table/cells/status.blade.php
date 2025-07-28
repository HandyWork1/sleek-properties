@props(['row', 'col'])

@php
    $statusRaw = $row->status ?? 'unknown';

    // Convert raw status values to a more readable format
    $status = str_replace('_', ' ', strtolower($statusRaw));
    $label = ucwords($status);

    $badgeClasses = match ($status) {
        'for sale' => 'bg-green-500 dark:bg-green-700',
        'for rent' => 'bg-yellow-500 dark:bg-yellow-700',
        'sold', 'rented' => 'bg-red-400 dark:bg-red-700 ',
        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
    };
@endphp

<span class="inline-block px-3 py-1 rounded-md text-xs font-medium text-gray-50 {{ $badgeClasses }}">
    {{ $label }}
</span>
