<aside
    x-data
    :class="sidebarExpanded ? 'w-64' : 'w-20'"
    class="fixed top-0 left-0 h-full z-40 bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300"
>
    {{-- Logo + Toggle --}}
    <div class="flex items-center justify-between px-4 py-4">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/company-logo.png') }}" :class="sidebarExpanded ? 'w-32' : 'w-10'" class="transition-all duration-300" />
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
        {{-- Nav item --}}
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home" class="group relative">
            <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
            <span
                x-show="!sidebarExpanded"
                class="absolute left-full ml-3 whitespace-nowrap bg-gray-700 text-white text-xs rounded px-2 py-1 hidden group-hover:block"
                x-cloak
            >
                Dashboard
            </span>
        </x-nav-link>
    </nav>
</aside>
