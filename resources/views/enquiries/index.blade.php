<x-app-layout>
    <x-slot name="header">
        {{-- Page Title & Actions --}}
        <div class="flex justify-between items-center my-4">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Enquiries</h1>

            <div class="flex items-center gap-2">
                <a href="#"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                    <x-heroicon-s-cloud-arrow-down class="w-5 h-5" />
                    Download
                </a>
                
                <a href="#"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                    <x-heroicon-s-printer class="w-5 h-5" />
                    Print
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Enquiries Table --}}
    <x-table
        :columns="[
            ['key'=>'created_at','label'=>'Date', 'formatter'=>fn($row)=>format_date($row->created_at)],
            ['key'=>'subject','label'=>'Subject', 'component'=>'table.cells.enquiry-subject'],
            ['key'=>'user_info','label'=>'Sender', 'component'=>'table.cells.enquiry-user'],
            ['key'=>'actions','label'=>'Action', 'component'=>'table.cells.enquiry-actions']
        ]"
        :rows="$enquiries"
        searchable
        :pagination="$enquiries"
    >
        <x-slot name="extraFilters">
            <form method="GET" x-data="{ search: '{{ request('search') }}' }" class="space-y-6">

                {{-- Filters Row --}}
                <div class="flex flex-col lg:flex-row gap-4 flex-wrap items-start lg:items-center">

                    {{-- Filters Label --}}
                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">Filters</span>

                    {{-- Search with Debounce --}}
                    <div class="relative w-full max-w-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            x-model.debounce.500ms="search"
                            x-on:input.debounce.500ms="$el.form.submit()"
                            placeholder="Search…"
                            class="w-full pl-10 pr-3 py-2 border rounded-md text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                        />
                    </div>

                    {{-- Start Date --}}
                    <div class="flex items-center gap-x-2 w-48">
                        <label for="start" class="text-sm text-gray-700 dark:text-gray-300 font-medium">Start</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-heroicon-o-calendar class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </div>
                            <input
                                datepicker
                                datepicker-format="dd/mm/yyyy"
                                id="start"
                                name="start"
                                value="{{ request('start') }}"
                                placeholder="dd/mm/yyyy"
                                onchange="this.form.submit()"
                                autocomplete="off"
                                class="w-full pl-10 pr-3 py-2 border rounded-md text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            />
                        </div>
                    </div>

                    {{-- End Date --}}
                    <div class="flex items-center gap-x-2 w-48">
                        <label for="end" class="text-sm text-gray-700 dark:text-gray-300 font-medium">End</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-heroicon-o-calendar class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                            </div>
                            <input
                                datepicker
                                datepicker-format="dd/mm/yyyy"
                                id="end"
                                name="end"
                                value="{{ request('end') }}"
                                placeholder="dd/mm/yyyy"
                                onchange="this.form.submit()"
                                autocomplete="off"
                                class="w-full pl-10 pr-3 py-2 border rounded-md text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                            />
                        </div>
                    </div>
                </div>

                {{-- Per Page Selector --}}
                <div class="flex items-center gap-x-2 mb-8">
                    <label for="perPage" class="text-sm text-gray-700 dark:text-gray-300 font-medium">Enquiries per Page</label>
                    <select
                        id="perPage"
                        name="perPage"
                        onchange="this.form.submit()"
                        class="px-3 py-2 border rounded-md text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
                        @foreach([5, 10, 25, 50] as $n)
                            <option value="{{ $n }}" @selected(request('perPage', 10) == $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

            </form>
        </x-slot>
    </x-table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $enquiries->links() }}
    </div>
    </div>


    {{-- Right Activity Panel --}}
    <aside class="w-64 border-l px-4 py-6 bg-gray-100 dark:bg-gray-900 hidden lg:block">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Activities</h3>
        <div class="space-y-3">
            @foreach($recentUsers as $user)
                {{-- @if($user) --}}
                <div class="flex items-center space-x-3">
                    <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                            class="w-8 h-8 rounded-lg object-cover" />
                    <div class="text-sm">
                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->getFullNameAttribute() }}</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $user->email }}</div>
                    </div>
                </div>
                {{-- @endif --}}
            @endforeach
        </div>
    </aside>
    
</x-app-layout>