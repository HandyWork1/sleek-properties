<aside>
    {{-- MOBILE SIDEBAR (only on <md) --}}
    <div
        x-show="sidebarMobileOpen"
        x-cloak
        class="fixed inset-0 z-50 flex md:hidden"
    >
        {{-- Backdrop --}}
        <div
        @click="sidebarMobileOpen = false"
        x-show="sidebarMobileOpen"
        x-transition.opacity
        class="absolute inset-0 bg-black bg-opacity-50"
        ></div>

        {{-- Panel --}}
        <div
            x-show="sidebarMobileOpen"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            :class="sidebarExpanded ? 'w-64' : 'w-20'"
            class="relative z-50 h-full bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col transition-all duration-300"
        >
            {{-- Logo + Close Button --}}
            <div class="flex items-center justify-between px-4 py-4">
                <a href="{{ route('dashboard') }}">
                <img
                    src="{{ asset('images/company-logo.png') }}"
                    :class="sidebarExpanded ? 'w-32' : 'w-10'"
                    class="transition-all duration-300"
                />
                </a>
                <button
                @click="sidebarMobileOpen = false"
                class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                <x-heroicon-o-x-mark class="w-6 h-6 text-gray-700 dark:text-gray-200"/>
                </button>
            </div>

            {{-- Nav items --}}
            <nav class="flex-1 px-2 space-y-2 overflow-y-auto">
                <x-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
                icon="home"
                class="group relative"
                >
                <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-gray-700 text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >Dashboard</span>
                </x-nav-link>
                
                <x-nav-link
                :href="route('properties.index')"
                :active="request()->routeIs('properties*')"
                icon="document"
                class="group relative"
                >
                <span x-show="sidebarExpanded" class="ml-3">All Listings</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-gray-700 text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >All Listings</span>
                </x-nav-link>

                <x-nav-link
                :href="route('enquiries.index')"
                :active="request()->routeIs('enquiries*')"
                icon="chat-bubble-left-ellipsis"
                class="group relative"
                >
                <span x-show="sidebarExpanded" class="ml-3">Enquiries</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-gray-700 text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >Enquiries</span>
                </x-nav-link>
            </nav>
        </div>
    </div>

    {{-- DESKTOP SIDEBAR (only on ≥md) --}}
    <div
        x-data
        :class="sidebarExpanded ? 'w-64' : 'w-20'"
        class="fixed top-0 left-0 h-full z-40 bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300
            hidden md:block"
    >
        {{-- Logo + Toggle --}}
        <div class="flex items-center justify-between px-4 py-4">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/company-logo.png') }}" :class="sidebarExpanded ? 'w-32' : 'hidden'" class="transition-all duration-300" />
            </a>

            {{-- Sidebar Toggle Button --}}
            <button @click="sidebarExpanded = !sidebarExpanded" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition">
                <template x-if="sidebarExpanded">
                    <x-heroicon-o-bars-3-bottom-left class="w-5 h-5" />
                </template>
                <template x-if="!sidebarExpanded">
                    <x-heroicon-o-chevron-right class="w-5 h-5" />
                </template>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="space-y-2 mx-auto mt-6 px-2">
            {{-- Nav items --}}
            <x-nav-link :href="route('dashboard')" 
            :active="request()->routeIs('dashboard')" 
            icon="home" 
            class="group relative">
                <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-white dark:bg-gray-700 text-gray-600 dark:text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >
                    Dashboard
                </span>
            </x-nav-link>

            <x-nav-link 
            :href="route('properties.index')" 
            :active="request()->routeIs('properties*')" 
            icon="document" 
            class="group relative">
                <span x-show="sidebarExpanded" class="ml-3">All Listings</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-white dark:bg-gray-700 text-gray-600 dark:text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >
                    All Listings
                </span>
            </x-nav-link>

            <x-nav-link 
            :href="route('enquiries.index')" 
            :active="request()->routeIs('enquiries*')" 
            icon="chat-bubble-left-ellipsis" 
            class="group relative">
                <span x-show="sidebarExpanded" class="ml-3">Enquiries</span>
                <span
                    x-show="!sidebarExpanded"
                    class="absolute left-full ml-3 whitespace-nowrap bg-white dark:bg-gray-700 text-gray-600 dark:text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                    x-cloak
                >
                    Enquiries
                </span>
            </x-nav-link>
        </nav>
    </div>
</aside>
