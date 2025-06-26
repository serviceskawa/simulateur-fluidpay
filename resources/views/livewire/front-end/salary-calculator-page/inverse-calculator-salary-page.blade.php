<div style="font-family: 'Poppins', sans-serif;">
    <div class="container py-5">
        <!-- Formulaire Calcul Salaire Net -->
        <form wire:submit.prevent="calculerInverse" class="card shadow-sm p-4 mx-auto border-1"
            style="max-width: 750px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);">
            <h4 class="mb-4 text-dark fw-bold">Calcul du Salaire Net</h4>

            <div class="row g-3 mb-1">
                <div class="col-md-6">
                    <x-form.input
                        name="salaire_net"
                        label="Salaire Net (FCFA)"
                        type="number"
                        wire:model="salaire_net"
                        placeholder="Ex: 200000"
                        class="form-control"

                    />
                </div>
                <div class="col-md-6">
                  <x-form.select
    name="mois_inverse"
    label="Mois de la paie"
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
    wire:model="mois_inverse"
    label-class="form-label d-block mb-2 fw-semibold text-muted text-start"
/>


                </div>
            </div>

            <div class="row g-3 mb-1">
                <div class="col-md-6">
                    <x-form.input
                        name="cnss_ouvriere"
                        label="CNSS Ouvrière (%)"
                        type="number"
                        step="0.1"
                        wire:model="cnss_ouvriere"
                        class="form-control"

                    />
                </div>
                <div class="col-md-6">
                    <x-form.input
                        name="cnss_patronale"
                        label="CNSS Patronale (%)"
                        type="number"
                        step="0.1"
                        wire:model="cnss_patronale"
                        class="form-control"

                    />
                </div>
            </div>
            <br>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <x-form.input
                        name="vps"
                        label="VPS (%)"
                        type="number"
                        wire:model="vps"
                        class="form-control"

                    />
                </div>
            </div>

            <div class="text-end">
                <x-form.button type="submit" class="btn btn-sm px-4 shadow"
                    style="background-color: #003366; border: none; color: white; box-shadow: 0 4px 16px rgba(0, 51, 102, 0.6);"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Calculer</span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Calcul en cours...
                    </span>
                </x-form.button>
            </div>

            @if (!empty($resultats))
                <div class="mt-4 bg-white p-4 rounded shadow-sm border-0"
                    style="box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);">
                    <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Résultats —
                        {{ $type_calcul === 'brut' ? $mois_brut : $mois_inverse }}</h5>

                    <ul class="list-group list-group-flush mb-3">
                        @foreach ($resultats as $item)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">{{ $item['label'] }}</span>
                                <strong class="text-dark">{!! $item['val'] !!}</strong>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-end mt-3">
                        <x-form.button type="button" wire:click="$set('showModal', true)">
                            Générer fiche de paie
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
            </div class="mb-3">
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
                            <button type="button" class="btn btn-primary"
                        wire:click="
                         $set('showModal', false);
                         $set('showShareModal', true);
                        ">
                        Générer PDF
                       </button>

                        </div>
                    </div>
                </form>
            </x-form.modal>


            <x-form.modal :show="$showShareModal">
    <div class="p-4">
        <h5 class="mb-3 fw-bold">Partager ou Télécharger la Fiche de Paie</h5>

        <!-- Choix de l'option de partage -->
        <div class="mb-3">
            <label class="form-label d-block">Méthode de partage</label>

            <div class="form-check">
                <input class="form-check-input" type="radio" wire:model="shareOption" id="whatsappOption" value="whatsapp">
                <label class="form-check-label" for="whatsappOption">
                    WhatsApp
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" wire:model="shareOption" id="emailOption" value="email">
                <label class="form-check-label" for="emailOption">
                    E-mail
                </label>
            </div>
        </div>

        <!-- Champ e-mail affiché seulement si email est sélectionné -->
        @if ($shareOption === 'email')
            <div class="mb-3">
                <label class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" placeholder="example@mail.com" wire:model.defer="email" />
            </div>
        @endif

        <!-- Boutons d'action -->
        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
            <button type="button" class="btn btn-secondary" wire:click="$set('showShareModal', false)">
                Annuler
            </button>
            <button type="button" class="btn btn-primary" wire:click="downloadPdf">
                Télécharger
            </button>
        </div>
    </div>
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
</div>
