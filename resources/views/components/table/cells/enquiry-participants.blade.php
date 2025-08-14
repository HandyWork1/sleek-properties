@php
    $authId = auth()->id();
    $from = $row->fromUser;
    $to = $row->toUser;
    $sender = $from->id === $authId ? 'You' : $from->getFullNameAttribute();
    $recipient = $to->id === $authId ? 'You' : $to->getFullNameAttribute();
@endphp

<div class="text-sm text-gray-700 dark:text-gray-200">
    <strong>From:</strong> {{ $sender }}<br>
    <strong>To:</strong> {{ $recipient }}
</div>
