@props([
    'label' => '',
    'name' => '',
    'id' => '',
    'options' => [],
    'required' => false,
])

@php $hasError = $errors->has($name); @endphp

<div>
    @if($label)
        <label for="{{ $id ?: $name }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id ?: $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' =>
            'block w-full p-2.5 rounded-lg text-sm ' .
            ($hasError
                ? 'border-red-500 focus:ring-red-500 focus:border-red-500 bg-red-50 text-red-900 dark:border-red-600 dark:bg-gray-900 dark:text-red-400'
                : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white')
        ]) }}
    >
        <option value="">-- Select an option --</option>
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get($name)" class="mt-1" />
</div>
