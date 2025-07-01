<header class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center transition-all duration-300">

    {{-- Left Section: Toggle + Breadcrumb --}}
    <div class="flex items-center space-x-4">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 dark:text-gray-300 flex items-center space-x-1">
            <span>Page</span>
            @foreach(request()->segments() as $index => $segment)
                <span>/</span>
                @if ($index === array_key_last(request()->segments()))
                    <span class="text-gray-800 dark:text-white font-semibold capitalize">
                        {{ ucwords(str_replace('-', ' ', $segment)) }}
                    </span>
                @else
                    <span class="capitalize">{{ ucwords(str_replace('-', ' ', $segment)) }}</span>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Theme + Profile --}}
    <div x-data="{
        dark: localStorage.getItem('theme') === 'dark',
        toggleTheme() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark', dark)" 
    class="flex items-center space-x-4">

        <!-- Theme Toggle -->
        <button @click="toggleTheme" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <template x-if="!dark">
                <x-heroicon-o-moon class="w-5 h-5 text-gray-700 dark:text-gray-200" />
            </template>
            <template x-if="dark">
                <x-heroicon-o-sun class="w-5 h-5 text-gray-300 dark:text-yellow-300" />
            </template>
        </button>

        <!-- Profile Dropdown -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    <span class="ml-2 px-2 py-0.5 text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full">
                        {{ ucfirst(Auth::user()->getRoleNames()->first()) ?? 'User' }}
                    </span>
                    <x-heroicon-o-chevron-down class="ml-2 w-4 h-4" />
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>
