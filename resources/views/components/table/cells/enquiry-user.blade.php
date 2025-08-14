@props(['row','col'])
@php $user = $row->fromUser; @endphp

<div class="flex items-center space-x-3">
  <img
    src="{{ $user?->profile_photo_url ?: asset('images/default-avatar.jpg') }}"
    alt="{{ $user?->getFullNameAttribute() }}"
    class="w-8 h-8 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
  >
  <div class="text-sm">
    <div class="font-medium text-gray-900 dark:text-gray-100">
      {{ $user?->getFullNameAttribute() ?? '—' }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
      {{ $user?->email ?? '' }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
      {{ $user?->phone ?? '' }}
    </div>
  </div>
</div>
