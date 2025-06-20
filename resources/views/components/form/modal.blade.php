<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- En-tête -->
      <div class="modal-header">
        <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>

      <!-- Corps -->
      <div class="modal-body">
        {{ $slot }}
      </div>

      <!-- Pied de page (facultatif) -->
      @isset($footer)
        <div class="modal-footer">
          {{ $footer }}
        </div>
      @endisset

    </div>
  </div>
</div>
