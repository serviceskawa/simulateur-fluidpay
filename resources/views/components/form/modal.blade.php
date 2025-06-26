{{-- resources/views/components/form/modal.blade.php --}}
@props([
    'show' => false,
])

@if ($show)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-modal="true" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden position-relative">

                {{-- Bouton fermer en haut à droite --}}
                <button type="button"
                        class="btn-close position-absolute end-0 m-3"
                        wire:click="$set('showModal', false); $set('showShareModal', true)"
                        aria-label="Fermer"
                        style="z-index: 10;">
                </button>


                <div class="modal-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
@endif
