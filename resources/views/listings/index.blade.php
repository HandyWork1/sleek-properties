<x-app-layout>
    <div class="py-6">
        {{-- Page Title & Actions --}}
        <div class="flex justify-between items-center my-4">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">All Listings</h1>

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

        {{-- Listings Table --}}
        <x-table
            :columns="[
            ['key'=>'id','label'=>'#'],
            ['key'=>'name','label'=>'Listing Name'],
            ['key'=>'size','label'=>'Size (sqft)', 'formatter'=>fn($row)=>format_size($row->size)],
            ['key'=>'bedrooms','label'=>'Bedrooms'],
            ['key'=>'location.name','label'=>'Location', 'formatter'=>'location'],
            ['key'=>'price','label'=>'Price', 'formatter'=>fn($row)=>format_price($row->price)],
            ['key'=>'agent','label'=>'Agent','formatter'=>'agent'],
            ['key'=>'created_at','label'=>'Date Listed', 'formatter'=>fn($row)=>format_date($row->created_at)],
            ['key'=>'status','label'=>'Status', 'formatter'=>'status'],
            ['key'=>'actions','label'=>'Actions','component'=>'table.cells.listing-actions']
            ]"
            :rows="$properties"
            searchable
            :filters="[
            ['name'=>'location','label'=>'Location','options'=>$locations],
            ]"
            :pagination="$properties"
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
                        <label for="perPage" class="text-sm text-gray-700 dark:text-gray-300 font-medium">Listings per Page</label>
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
    </div>
</x-app-layout>