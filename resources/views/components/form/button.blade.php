<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-primary d-inline-flex align-items-center']) }}>

    @if($icon && $iconPosition === 'start')
        <i class="fa {{ $icon }} me-1"></i>
    @endif

    
    @if(trim($slot))
        {{ $slot }}
    @endif

    @if($icon && $iconPosition === 'end')
        <i class="fa {{ $icon }} ms-1"></i>
    @endif
</button>
