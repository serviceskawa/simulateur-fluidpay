<div class="form-check mb-3">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="1"
        {{ $attributes->merge([
            'class' => 'form-check-input'
        ]) }}
    >
    <label class="form-check-label" for="{{ $name }}">
        {{ $label }}
    </label>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
