@props([
    'name',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'class' => '',
    'labelClass' => 'form-label fw-semibold text-start d-block',
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           {{ $attributes->merge(['class' => $class]) }}
           placeholder="{{ $placeholder }}">
</div>
