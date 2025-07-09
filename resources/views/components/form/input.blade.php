<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}"
        {{ $attributes->merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')]) }}
    />

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
