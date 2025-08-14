@php
  /** $row is an Enquiry model */
  $isUnread = method_exists($row, 'isUnreadFor') ? $row->isUnreadFor(auth()->id()) : ($row->read_at === null && $row->to_user_id === auth()->id());
  $replies = $row->messages_count ?? ($row->messages()->count() ?? 0);
@endphp

<div class="flex flex-col">
  <div class="flex items-center gap-3">
    <a href="{{ route('enquiries.show', $row) }}"
       class="{{ $isUnread ? 'font-semibold text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
      {{ $row->subject }}
    </a>

    @if($isUnread)
      <span class="inline-block text-xs px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded ml-2">Unread</span>
    @endif
  </div>

  <div class="text-xs text-gray-500 mt-1">
    @if($replies > 1)
      <span class="text-blue-600 font-medium">{{ $replies }} replies</span>
    @else
      <span>{{ $replies }} message{{ $replies > 1 ? 's' : '' }}</span>
    @endif
  </div>
</div>
