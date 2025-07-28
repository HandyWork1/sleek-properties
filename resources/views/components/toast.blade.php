<div
    x-data="{ toasts: [] }"
    x-init="
        window.addEventListener('toast', e => {
            toasts.push({
                id: Date.now(),
                type: e.detail.type || 'success',
                message: e.detail.message || '',
                timeout: e.detail.timeout || 4000
            });
        })
    "
    class="fixed top-4 right-4 z-50 space-y-2"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, toast.timeout)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-4 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex items-start w-full max-w-sm p-4 border-l-4 rounded shadow-md"
            :class="{
                'bg-green-100 text-green-800 border-green-400': toast.type === 'success',
                'bg-red-100 text-red-800 border-red-400': toast.type === 'error',
                'bg-blue-100 text-blue-800 border-blue-400': toast.type === 'info',
                'bg-yellow-100 text-yellow-800 border-yellow-400': toast.type === 'warning'
            }"
        >
            <div class="mr-3">
                <template x-if="toast.type === 'success'">
                    <x-heroicon-o-check-circle class="w-6 h-6" />
                </template>
                <template x-if="toast.type === 'error'">
                    <x-heroicon-o-x-circle class="w-6 h-6" />
                </template>
                <template x-if="toast.type === 'info'">
                    <x-heroicon-o-information-circle class="w-6 h-6" />
                </template>
                <template x-if="toast.type === 'warning'">
                    <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
                </template>
            </div>

            <div class="flex-1 text-sm font-medium leading-snug" x-text="toast.message"></div>

            <button @click="show = false" class="ml-4 text-xl font-bold leading-none">&times;</button>
        </div>
    </template>
</div>
