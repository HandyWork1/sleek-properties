{{-- resources/views/enquiries/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start space-y-3">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Enquiries</h2>
            <form action="{{ route('dashboard') }}" method="GET">
                <button type="submit"
                    class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-blue-700 
                    border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
                    hover:text-white dark:hover:bg-indigo-600 transition duration-150">
                    <x-heroicon-o-arrow-left class="w-5 h-5 mr-1" />
                    Back
                </button>
            </form>
        </div>
    </x-slot>

    {{-- Enquiry Chat Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        {{-- Message Header --}}
        <div class="flex items-center mb-4">
            <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.jpg') }}" alt="avatar" class="w-10 h-10 rounded-lg">
            <div class="ml-3">
                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ Auth::user()->getFullNameAttribute() }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('g:i A') }}</p>
            </div>
        </div>

        {{-- Property Preview --}}
        <div class="mb-4 ml-12 space-y-2 border-l-4 border-gray-300 pl-4">
            <img src="{{ $property->getFirstMediaUrl('images', 'thumb') }}" alt="Property Image" 
            class="w-42 h-32 object-cover rounded-md">
            <div class="space-y-2">
                <div class="text-xs text-gray-500 dark:text-gray-400">Date Created: {{ format_date($property->created_at) }}</div>
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $property->name }}</div>
                <div class="flex items-center">
                    <a href="{{ route('properties.show',$property) }}"
                        class="inline-flex items-center justify-center px-6 py-1.5 text-sm font-medium text-blue-700 
                        border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
                        hover:text-white dark:hover:bg-indigo-600 transition">
                        View
                    </a>
                </div>
            </div>
        </div>

        {{-- Rich Text Message Input --}}
        <form action="{{ route('properties.enquire', $property) }}" method="POST">
            @csrf

            <div class="border rounded-2xl">
                <div id="quill-editor" class="bg-white dark:bg-gray-800"></div>
                <input type="hidden" name="subject" value="Enquiry about {{ $property->name }}" id="quill-subject">
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
    </div>
    </div>

    {{-- Right Activity Panel --}}
    <aside class="w-64 border-l px-4 py-6 bg-gray-100 dark:bg-gray-900 hidden lg:block">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Activities</h3>
        <div class="space-y-3">
            @foreach([Auth::user(), $property->agent, $property->landlord?->user] as $user)
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
</div>


{{-- Quill Init Script --}}
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
</script>
</x-app-layout>
