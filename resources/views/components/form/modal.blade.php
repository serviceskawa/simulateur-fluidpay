@props(['show' => false])

<div
    x-data="{ open: @entangle($attributes->wire('model') ?? 'show').defer }"
    x-show="open"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    style="display: none;"
>
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl overflow-auto max-h-[90vh]">
        {{ $slot }}
    </div>
</div>
