@props([
    'active' => false,
    'icon' => '',
    'bgColor' => 'bg-indigo-500',
])

@php
$classes = $active
    ? 'flex items-center space-x-3 px-4 py-2 rounded-md bg-white dark:bg-gray-700 text-gray-900 font-semibold dark:text-white shadow-sm'
    : 'flex items-center space-x-3 px-4 py-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }} class="flex items-center justify-center">
    <div class="p-2 rounded-xl {{ $bgColor }} bg-opacity-20 text-md text-indigo-600 dark:text-indigo-400">
                <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
    </div>
    {{ $slot }}
</a>
