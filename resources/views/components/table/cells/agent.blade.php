@props(['row','col'])
@php $agent = $row->agent; @endphp

<div class="flex items-center space-x-3">
  <img
    src="{{ $agent?->profile_photo_url ?: asset('images/default-avatar.jpg') }}"
    alt="{{ $agent?->getFullNameAttribute() }}"
    class="w-8 h-8 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
  >
  <div class="text-sm">
    <div class="font-medium text-gray-900 dark:text-gray-100">
      {{ $agent?->getFullNameAttribute() ?? '—' }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
      {{ $agent?->email ?? '' }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
      {{ $agent?->phone ?? '' }}
    </div>
  </div>
</div>
