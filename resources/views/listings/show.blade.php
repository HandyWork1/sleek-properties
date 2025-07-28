<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start space-y-3">
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center justify-center px-3 py-1.5 text-sm font-medium text-blue-700 
            border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
            hover:text-white dark:hover:bg-indigo-600 transition">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2"/>
            Back
        </a>
        <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            All Listings / {{ $property->name }}
        </h1>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 py-6">

        {{-- Left: Images and Thumbnails --}}
        <div class="lg:col-span-3 space-y-6">
            
            {{-- Carousel --}}
            <div id="property-carousel" class="relative" data-carousel="static">

                {{-- Slides wrapper --}}
                <div class="relative h-[400px] overflow-hidden rounded-lg">
                @foreach($property->getMedia('images') as $media)
                    <div
                    data-carousel-item
                    class="@if($loop->first) block @else hidden @endif duration-700 ease-in-out"
                    >
                    <img 
                        src="{{ $media->getUrl('large') }}" 
                        alt="Photo {{ $loop->iteration }} of {{ $property->name }}"
                        class="block w-full h-full object-cover"
                        loading="lazy"
                    />
                    </div>
                @endforeach
                </div>

                {{-- Prev/Next --}}
                <button type="button"
                    data-carousel-prev
                    class="absolute z-30 top-1/2 left-4 -translate-y-1/2 bg-gray-800 bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-2">
                    <x-heroicon-o-chevron-left class="w-6 h-6"/>
                    <span class="sr-only">Previous</span>
                </button>
                <button type="button"
                    data-carousel-next
                    class="absolute z-30 top-1/2 right-4 -translate-y-1/2 bg-gray-800 bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-2">
                    <x-heroicon-o-chevron-right class="w-6 h-6"/>
                    <span class="sr-only">Next</span>
                </button>

                {{-- Thumbnails --}}
                <div class="flex justify-center space-x-2 mt-4">
                @foreach($property->getMedia('images') as $idx => $media)
                    <button type="button"
                            data-carousel-slide-to="{{ $idx }}"
                            aria-label="Go to slide {{ $idx+1 }}"
                            class="w-16 h-10 rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 hover:ring-2 ring-indigo-500">
                    <img
                        src="{{ $media->getUrl('thumb') }}"
                        alt="Thumbnail {{ $idx+1 }}"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    />
                    </button>
                @endforeach
                </div>
            </div>

            {{-- Listing Title + Status --}}
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $property->name }}</h2>
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($property->status==='for_sale') bg-green-100 text-green-800
                            @elseif($property->status==='for_rent') bg-yellow-100 text-yellow-800
                            @elseif(in_array($property->status,['sold','rented'])) bg-red-100 text-red-800
                            @endif">
                {{ Str::headline(str_replace('_',' ',$property->status)) }}
                </span>
            </div>

            {{-- Key Details Row 1 --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ format_date($property->created_at) }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Date Created</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->location->name }}, {{ $property->country->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Location</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ format_size($property->size) }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Size</div>
                </div>
            </div>

            {{-- Key Details Row 2 --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->type->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Property Type</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->bedrooms }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Bedrooms</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->bathrooms }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Bathrooms</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->furnishingStatus->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Furnishing</div>
                </div>

                <div class="flex flex-col space-y-1">
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $property->condition->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Condition</div>
                </div>

            </div>
        </div>

        {{-- Right Sidebar: Details & Enquire --}}
        <aside class="space-y-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm space-y-4">
                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ format_price($property->price) }}</div>
                <a href="#"
                class="block w-full text-center px-4 py-2 font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition">
                Enquire
                </a>
            </div>

            {{-- Agent Details --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm space-y-3">
                <div class="text-xs uppercase font-semibold text-gray-500 dark:text-gray-400">Agent Details</div>
                <div class="flex items-center">
                    <img src="{{ $property->agent->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                        alt="{{ $property->agent->getFullNameAttribute() ?? '—' }}"
                        class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-700"/>
                </div>
                <div class="text-sm">
                    <div class="font-semibold capitalize text-gray-900 dark:text-gray-100">{{ $property->agent->getFullNameAttribute() ?? '—'  }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $property->agent->email }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $property->agent->phone }}</div>
                </div>
            </div>

            {{-- Client Details (if any) --}}
            @if($property->landlord)
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm space-y-3">
                <div class="font-semibold text-gray-700 dark:text-gray-300">Client Details</div>
                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $property->landlord->name }}</div>
                <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $property->landlord->email }}</div>
                <div class="text-gray-500 dark:text-gray-400 text-xs">{{ $property->landlord->phone }}</div>
                </div>
            @endif
        </aside>

    </div>

    {{-- Similar Listings --}}
    @if($similarListings->count())
        <div class="my-10">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Similar Listings</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarListings as $sim)
                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm">
                    <img src="{{ $sim->getFirstMediaUrl('images','medium') }}"
                        alt="{{ $sim->name }}"
                        class="w-full h-32 object-cover"/>
                    <div class="p-4 space-y-2">
                        <div class="text-xs text-gray-500 dark:text-gray-400">Date Created: {{ format_date($sim->created_at) }}</div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $sim->name }}</div>
                        <div class="flex items-center">
                            <a href="{{ route('properties.show',$sim) }}"
                             class="inline-flex items-center justify-center px-10 py-1.5 text-sm font-medium text-blue-700 
                             border border-indigo-600 dark:border-indigo-700 rounded-md hover:bg-indigo-500 
                             hover:text-white dark:hover:bg-indigo-600 transition">
                                View
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

</x-app-layout>
