<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="form-label mb-2 text-muted fw-semibold">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'form-select border border-secondary-subtle text-body bg-light rounded px-3 py-2 fw-normal shadow-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all' .
                       ($errors->has($name) ? ' is-invalid border-danger' : '')
        ]) }}
    >
        <option value="" disabled selected hidden>— Sélectionner —</option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback mt-1 small">{{ $message }}</div>
    @enderror
</div>
