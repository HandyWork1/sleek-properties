@props([
    'label' => '',
    'id' => '',
    'name' => '',
    'rows' => 4,
    'value' => '',
    'required' => false,
    'placeholder' => '',
])

<div>
    @if($label)
        <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
            focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:text-white']) }}
    >{{ old($name, $value) }}</textarea>
</div>
