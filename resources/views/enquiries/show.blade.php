{{-- resources/views/enquiries/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start space-y-3">
            {{-- Page Title --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Enquiries') }}
            </h2>
            <a href="{{ route('enquiries.index') }}"
                class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-blue-700 
                    border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
                    hover:text-white dark:hover:bg-indigo-600 transition duration-150">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2"/>
                Back
            </a>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6 max-w-7xl mx-auto space-y-6">

        {{-- Message Thread --}}
        <div class="space-y-6">
            @foreach($enquiry->messages as $index => $msg)
                @php
                    $isOwnMessage = $msg->sender_id === auth()->id();
                    $senderName = $isOwnMessage ? 'You' : $msg->sender->getFullNameAttribute();
                @endphp

                <div class="flex items-start {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                    {{-- Profile Photo --}}
                    @if(!$isOwnMessage)
                        <img src="{{ $msg->sender->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                            alt="{{ $senderName }}"
                            class="w-10 h-10 rounded-lg mr-3 mt-1" />
                    @endif

                    {{-- Message Content --}}
                    <div class="max-w-xl">
                        {{-- Sender and Time --}}
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span class="font-bold text-gray-800 dark:text-gray-200">
                                {{ $senderName }}
                            </span>
                            <span class="text-gray-400">·</span>
                            <span title="{{ $msg->created_at->format('Y-m-d H:i:s') }}">
                                {{ $msg->created_at->format('M j, Y \a\t g:i A') }}
                            </span>
                        </div>

                        {{-- Chat Bubble --}}
                        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg space-y-4">
                            <span class="text-gray-900 dark:text-white">{!! $msg->body !!}</span>

                            @if($index === 0)
                                {{-- Property Quote --}}
                                <div class="flex gap-4 items-start mt-2">
                                    <img src="{{ $enquiry->property->getFirstMediaUrl('images', 'thumb') }}"
                                        alt="{{ $enquiry->property->name }}"
                                        class="w-24 h-24 object-cover rounded" />
                                    <div class="text-sm space-y-1">
                                        <p class="text-gray-500 dark:text-gray-400 text-xs">
                                            Date Created: {{ format_date($enquiry->property->created_at) }}
                                        </p>
                                        <p class="font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $enquiry->property->name }}
                                        </p>
                                        <a href="{{ route('properties.show', $enquiry->property) }}"
                                        class="inline-flex items-center justify-center px-6 py-1.5 text-sm font-medium text-blue-700 
                                                border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
                                                hover:text-white dark:hover:bg-indigo-600 transition">
                                            <x-heroicon-o-eye class="w-4 h-4 mr-1"/>
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Profile Photo (if own message) --}}
                    @if($isOwnMessage)
                        <img src="{{ $msg->sender->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                            alt="{{ $senderName }}"
                            class="w-10 h-10 rounded-lg ml-3 mt-1" />
                    @endif
                </div>
            @endforeach
        </div>


        {{-- Reply Form --}}
        <form action="{{ route('enquiries.reply', $enquiry) }}" method="POST">
            @csrf

            <div class="border rounded-2xl">
                <div id="quill-editor" class="bg-white dark:bg-gray-800"></div>
                <input type="hidden" name="body" id="quill-body">
                <div class="mt-3 px-1 flex items-center justify-between">
                    <div class="flex space-x-1 text-gray-500 dark:text-gray-400">
                        <button type="button" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <x-heroicon-o-paper-clip class="w-5 h-5" />
                        </button>
                        <button type="button" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <x-heroicon-o-face-smile class="w-5 h-5" />
                        </button>
                        <button type="button" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <x-heroicon-o-at-symbol class="w-5 h-5" />
                        </button>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-gray-500 rounded-md">
                        <x-heroicon-s-paper-airplane class="w-5 h-5 mr-1" />
                    </button>
                </div>
            </div>
        </form>

        {{-- <form action="{{ route('enquiries.reply', $enquiry) }}" method="POST"
              class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mt-6 space-y-4">
            @csrf
            {{-- Quill Toolbar and Editor --}}
            {{-- <div id="editor-toolbar" class="border-b border-gray-300 dark:border-gray-600 pb-2">
                <div id="toolbar" class="flex gap-2">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-link"></button>
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                </div>
            </div> --}}
            {{-- <div id="quill-editor" class="bg-gray-50 dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100 p-2 rounded h-32"></div>
            <input type="hidden" name="body" id="quill-message">

            <div class="flex justify-end">
                <button type="submit"
                        class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md 
                               hover:bg-indigo-700 transition">
                    <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2 rotate-90"/>
                    Send
                </button>
            </div> --}}
        {{-- </form> --}}
    </div>
    </div>

    {{-- Right Activity Panel --}}
    <aside class="w-64 border-l px-4 py-6 bg-gray-100 dark:bg-gray-900 hidden lg:block">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Activities</h3>
        <div class="space-y-3">
            @foreach([Auth::user(), $enquiry->property->agent, $enquiry->property->landlord?->user] as $user)
                @if($user)
                <div class="flex items-center space-x-3">
                    <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                            class="w-8 h-8 rounded-lg object-cover" />
                    <div class="text-sm">
                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->getFullNameAttribute() }}</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $user->email }}</div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </aside>

    {{-- Quill Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Initialize Quill editor
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Type your message here...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ]
                }
            });
            // Handle text change to update hidden input using Quill's text-change event
            quill.on('text-change', function() {
                const message = document.querySelector('#quill-body');
                message.value = quill.root.innerHTML;
            });
            
            // Set initial value for hidden input
            document.querySelector('form').addEventListener('submit', function (e) {
                message.value = quill.root.innerHTML;
        
            });
        });
        // const quill = new Quill('#quill-editor', {
        //     theme: 'snow',
        //     modules: {
        //         toolbar: '#toolbar'
        //     }
        // });

        // document.querySelector('form').addEventListener('submit', function (e) {
        //     document.querySelector('#quill-message').value = quill.root.innerHTML;
        // });
    </script>

</x-app-layout>
