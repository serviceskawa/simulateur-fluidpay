<div style="font-family: 'Noto Sans Kawi', sans-serif;">
    <style>
        label {
            font-size: 14px !important;

        }
    </style>



    <div class="card p-4 mx-auto shadow-sm border-1" id="calculateur"
        style="max-width: 750px;   box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);">
        <h5 class="mb-4 text-start text-dark fw-semibold">Calcul à partir du salaire brut</h5>

        <style>
            .small-label {
                font-size: 14px !important;
            }

            .small-input {
                font-size: 14px !important;
            }

            .small-input::placeholder {
                font-size: 13px;
                color: #777;
            }

            /* Pour tous les placeholders */
            ::placeholder {
                font-size: 14px;
                color: #777;
                /* facultatif */
            }

            /* Si tu veux cibler uniquement les champs avec une classe spécifique */
            .small-input::placeholder {
                font-size: 14px;
                color: #777;
            }
        </style>

        <div class="row g-3 mb-input">
            <div class="col-md-6">
                <x-form.input name="salaire_brut" label="Salaire Brut (FCFA)" type="number" wire:model="salaire_brut"
                    placeholder="Ex: 250000" placeholder-class="font-size: 14px" label-class="small-label text-start"
                    input-class="small-input" />
                {{-- @error('salaire_brut')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror --}}
            </div>

            <div class="col-md-6">
                <x-form.select name="mois_brut" label="Mois de paie" wire:model="mois_brut" :options="[
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
                    label-class="small-label text-start  fw-semibold" input-class="small-input" />
            </div>
        </div>

        <div class="row g-3 mb-input">
            <div class="col-md-6">
                <x-form.input name="cnss_ouvriere_brut" label="CNSS Ouvrière (%)" type="number" step="0.1"
                    wire:model="cnss_ouvriere_brut" label-class="small-label text-start  fw-semibold"
                    input-class="small-input" placeholder-class="font-size: 14px" />
            </div>

            <div class="col-md-6">
                <x-form.input name="cnss_patronale_brut" label="CNSS Patronale (%)" type="number" step="0.1"
                    wire:model="cnss_patronale_brut" label-class="small-label text-start  fw-semibold"
                    input-class="small-input" placeholder-class="font-size: 14px" />
            </div>
        </div>

        <div class="row g-3  mb-input" style="margin-top: 10px">
            <div class="col-md-6">
                <x-form.input name="vps_brut" label="VPS (%)" type="number" wire:model="vps_brut"
                    label-class="small-label text-start  fw-semibold" input-class="small-input"
                    placeholder-class="font-size: 14px" />
            </div>
        </div>


        <div class="text-start">
           <x-form.button wire:click="calculer"
    wire:loading.attr="disabled"
    class="btn btn-sm px-4 mt-3 shadow"
    style="background-color: #273584; color: white; border: none; box-shadow: 0 4px 16px rgba(0, 51, 102, 0.6); font-size: 14px; padding: 6px 12px;">

    <span wire:loading.remove wire:target="calculer">Calculer</span>
    <span wire:loading wire:target="calculer">Chargement...</span>
</x-form.button>





        </div>

        @if ($resultats)
            <div class="mt-4 bg-white p-4 rounded shadow-sm border-0" style="box-shadow: 0 6px 20px rgba(0,0,0,0.08);">

                <ul class="list-group list-group-flush mb-3">
                    @foreach ($resultats as $item)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{ $item['label'] }}</span>
                            <strong class="text-dark">{!! $item['val'] !!}</strong>
                        </li>
                    @endforeach
                </ul>

                <div class="text-start mt-3">
                    <x-form.button wire:click="calculer" style="font-size: 14px" wire:click="$set('showModal', true)">
                        Générer fiche de paie
                    </x-form.button>
                </div>
            </div>
        @endif
        <x-form.modal :show="$showModal">
    <div class="p-3 mx-auto" style="max-width: 800px;">
        <div class="modal-dialog modal-dialog-scrollable" style="max-height: 90vh;">
            <h2 class="fs-5 fw-bold mb-3">Générer la Fiche de Paie</h2>
        </div>

        <div class="modal-body p-4">
            <h6 class="fw-bold mb-3 text-start">INFORMATION DE L'EMPLOYÉ</h6>



            <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Période de paie</label>
        <input type="text" class="form-control form-control-sm" wire:model="periode_paie" readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Nom de l'employé</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: Jean Dupont" wire:model="nom_employe">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Date d'embauche</label>
        <input type="date" class="form-control form-control-sm" wire:model="date_embauche">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Poste / Fonction</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: Développeur Web" wire:model="poste_employe">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Type de contrat</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: CDI, CDD, Stage" wire:model="type_contrat">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">N° CNSS Employé</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: 123456789" wire:model="num_cnss_employe">
    </div>
    <div class="col-12 mb-3">
        <label class="form-label fw-semibold text-start d-block">Numéro IFU</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: 0000000000000" wire:model="ifu_employe">
    </div>
</div>

<h6 class="fw-bold mt-4 mb-3 text-start">INFORMATION DE L'EMPLOYEUR</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Nom de l'entreprise</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: Votre Entreprise S.A." wire:model="entreprise">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">N° CNSS Employeur</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: 987654321" wire:model="num_cnss_employeur">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Adresse de l'entreprise</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: 123 Rue de la Paix, Cotonou" wire:model="adresse_entreprise">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold text-start d-block">Numéro IFU</label>
        <input type="text" class="form-control form-control-sm" placeholder="Ex: 0000000000000" wire:model="ifu_employeur">
    </div>
</div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" @click="$wire.set('showModal', false)" class="btn btn-secondary btn-sm">
                    Annuler
                </button>
                <button type="submit"
    wire:click="generatePayslipPdf"
    wire:loading.attr="disabled"
    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center gap-2">

    <span wire:loading.remove wire:target="generatePayslipPdf">Générer PDF</span>
    <span wire:loading wire:target="generatePayslipPdf">Chargement...</span>
</button>

            </div>
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
    </div>
</div>
