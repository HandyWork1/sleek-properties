<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-medium text-gray-800 dark:text-white">
                {{ __('Welcome,') }} {{ Auth::user()->first_name ?? Auth::user()->first_name }}
            </h1>
            {{-- <x-dashboard-card :loading="$loading" title="Total Listings" :value="54" icon="building-office" bgColor="bg-blue-500" /> --}}
            <x-dashboard-card  title="Total Listings" :value="54" icon="building-office" bgColor="bg-blue-500" />
            
        </div>
    </div>
</x-app-layout>
