@props([
    'name',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'class' => 'form-control',
    'labelClass' => 'form-label text-start d-block',
    'inputClass' => '', // ✅ nouvelle prop pour personnaliser le champ
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
           placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => $class . ' ' . $inputClass]) }} />
</div>
