@props([
    'title' => '',
    'value' => '',
    'icon' => '',
    'bgColor' => 'bg-indigo-500',
    'loading' => false,
])

<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 flex items-center justify-between transition duration-300 min-h-[100px]">
    @if ($loading)
        {{-- Skeleton Version --}}
        <div class="w-full animate-pulse flex items-center justify-between space-x-4">
            <div class="flex-1 space-y-2">
                <div class="h-4 bg-gray-300 dark:bg-gray-700 rounded w-3/4"></div>
                <div class="h-6 bg-gray-300 dark:bg-gray-700 rounded w-1/2"></div>
            </div>
            <div class="h-10 w-10 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
        </div>
    @else
        {{-- Actual Content --}}
        <div>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $value }}</div>
        </div>
        <div class="p-3 rounded-full {{ $bgColor }} bg-opacity-20 text-2xl text-indigo-600 dark:text-indigo-400">
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6" />
        </div>
    @endif
</div>
