<div style="font-family: 'Poppins', sans-serif;">

  <form wire:submit.prevent="calculer" class="card p-4 mx-auto shadow-sm border-1" style="max-width: 750px;   box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);">
    <h4 class="mb-4 text-center text-dark fw-bold">Calcul du Salaire Brut</h4>

    <div class="row g-3 mb-1">
        <div class="col-md-6">
            <x-form.input
                name="salaire_brut"
                label="Salaire Brut (FCFA)"
                type="number"
                wire:model="salaire_brut"
                placeholder="Ex: 250000"
                class="form-control"
                label-class="text-start fw-semibold"
            />
            @error('salaire_brut')
    <div class="text-danger small mt-1">{{ $message }}</div>
   @enderror
        </div>
        <div class="col-md-6">
            <x-form.select
                name="mois_brut"
                label="Mois de paie"
                wire:model="mois_brut"
                :options="[
                    '' => 'Choisir',
                    'Janvier' => 'Janvier',
                    'Février' => 'Février',
                    'Mars' => 'Mars',
                    'Avril' => 'Avril',
                    'Mai' => 'Mai',
                    'Juin' => 'Juin',
                    'Juillet' => 'Juillet',
                    'Août' => 'Août',
                    'Septembre' => 'Septembre',
                    'Octobre' => 'Octobre',
                    'Novembre' => 'Novembre',
                    'Décembre' => 'Décembre',
                ]"
                class="form-control"
                label-class="text-start fw-semibold"
            />
        </div>
    </div>

    <div class="row g-3 mb-1">
        <div class="col-md-6">
            <x-form.input
                name="cnss_ouvriere_brut"
                label="CNSS Ouvrière (%)"
                type="number"
                step="0.1"
                wire:model="cnss_ouvriere_brut"
                class="form-control"
                label-class="text-start fw-semibold"
            />
        </div>
        <div class="col-md-6">
            <x-form.input
                name="cnss_patronale_brut"
                label="CNSS Patronale (%)"
                type="number"
                step="0.1"
                wire:model="cnss_patronale_brut"
                class="form-control"
                label-class="text-start fw-semibold"
            />
        </div>
    </div>
   <br>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <x-form.input
                name="vps_brut"
                label="VPS (%)"
                type="number"
                wire:model="vps_brut"
                class="form-control"
                label-class="text-start fw-semibold"
            />
        </div>
    </div>

    <div class="text-end">
        <x-form.button type="submit" class="btn btn-sm px-4 shadow" style="background-color: #003366; color: white; border: none; box-shadow: 0 4px 16px rgba(0, 51, 102, 0.6);" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="calculer">Calculer</span>
            <span wire:loading wire:target="calculer">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Calcul en cours...
            </span>
        </x-form.button>
    </div>

    @if ($resultats)
        <div class="mt-4 bg-white p-4 rounded shadow-sm border-0" style="box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
            <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Résultats — {{ $mois_brut }}</h5>
           <ul class="list-group list-group-flush mb-3">
                        @foreach ($resultats as $item)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">{{ $item['label'] }}</span>
                                <strong class="text-dark">{!! $item['val'] !!}</strong>
                            </li>
                        @endforeach
                    </ul>

            <div class="text-end mt-3">
                <x-form.button
                    type="button"
                    class="btn btn-sm px-4 shadow"
                    style="background-color: #003366; color: white; border: none; box-shadow: 0 4px 16px rgba(0, 51, 102, 0.6);"
                    wire:click="$set('showModal', true)"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="$set">Générer fiche de paie</span>
                    <span wire:loading wire:target="$set">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Chargement...
                    </span>
                </x-form.button>
            </div>
        </div>
    @endif



            <x-form.modal :show="$showModal">
<form wire:submit.prevent="generatePayslipPdf" class="p-3 mx-auto" style="max-width: 600px;">

                    <div class="modal-dialog" style="max-height: 90vh; overflow-y: auto;"class="px-6 py-4 border-bottom">
                        <h2 class="fs-5 fw-bold">Générer la Fiche de Paie</h2>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left">Période de paie</label>
                                <input type="text" class="form-control" value="Juin 2025">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left">Date de paiement</label>
                                <input type="date" class="form-control" value="2025-06-24">
                            </div>
                            <!-- Tu peux ajouter les autres champs ici -->

              <div class="mb-3">
              <label class="form-label fw-semibold d-block text-left">Nom de l'employé</label>
              <input type="text" class="form-control" placeholder="Ex: Jean Dupont">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Date d'embauche</label>
              <input type="date"  class="form-control">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Type de contrat</label>
              <input type="text" class="form-control" placeholder="Ex: CDI, CDD, Stage">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">N° CNSS Employé</label>
              <input type="text" class="form-control" placeholder="Ex: 123456789">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">N° CNSS Employeur</label>
              <input type="text" class="form-control" placeholder="Ex: 987654321">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold d-block text-left">Nom de l'entreprise</label>
              <input type="text" class="form-control" placeholder="Ex: Votre Entreprise S.A.">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold d-block text-left">Adresse de l'entreprise</label>
              <input type="text" class="form-control"  placeholder="Ex: 123 Rue de la Paix, Cotonou">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Poste/Fonction</label>
              <input type="text" class="form-control"  placeholder="Ex: Développeur Web">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Date de fin de contrat (Facultatif)</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Numéro IFU</label>
              <input type="text" class="form-control" placeholder="Ex: 0000000000000">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Logo de l'entreprise</label>
              <input type="file" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold d-block text-left">Signature Employeur (Image)</label>
              <input type="file" class="form-control">
            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-3 border-top pt-3">
                            <button type="button" @click="$wire.set('showModal', false)" class="btn btn-secondary">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Générer PDF</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Chargement...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </x-form.modal>

            <script>
                window.addEventListener('download-pdf', event => {
                    const pdfData = event.detail.pdfData;
                    const filename = event.detail.filename;

                    const link = document.createElement('a');
                    link.href = 'data:application/pdf;base64,' + pdfData;
                    link.download = filename;
                    link.click();
                });
            </script>

        </form>



</div>
