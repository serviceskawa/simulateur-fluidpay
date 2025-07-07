<div style="font-family: 'Noto Sans Kawi', sans-serif;">

<style>
    label {
        font-size: 14px !important;

    }
</style>


   <div class="container py-5">
        <form wire:submit.prevent="calculerInverse" class="card shadow-sm p-4 mx-auto border-1" style="max-width: 750px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);">
            <h4 class="mb-4 text-dark text-start fw-semibold">Calcul à partir du Salaire Net</h4>

            <div class="row g-3 mb-input ">
                <div class="col-md-6">
                    <x-form.input name="salaire_net" label="Salaire Net (FCFA)" type="number" wire:model="salaire_net"
                        placeholder="Ex: 200000"
                        class="form-control input-14"
                        label-class="form-label label-14 d-block text-start" />
                </div>
                <div class="col-md-6">
                    <x-form.select name="mois_inverse" label="Mois de la paie"
                        :options="[
                            
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
                        class="form-control input-14"
                        label-class="form-label label-14 d-block text-start" />
                </div>
            </div>

            <div class="row g-3 mb-input">
                <div class="col-md-6">
                    <x-form.input name="cnss_ouvriere" label="CNSS Ouvrière (%)" type="number" step="0.1"
                        wire:model="cnss_ouvriere"
                        class="form-control input-14"
                        label-class="form-label label-14 d-block text-start" />
                </div>
                <div class="col-md-6">
                    <x-form.input name="cnss_patronale" label="CNSS Patronale (%)" type="number" step="0.1"
                        wire:model="cnss_patronale"
                        class="form-control input-14"
                        label-class="form-label label-14 d-block text-start" />
                </div>
            </div>

            <div class="row g-3 mb-input" style="margin-top: 10px">
                <div class="col-md-6">
                    <x-form.input name="vps" label="VPS (%)" type="number" wire:model="vps"
                        class="form-control input-14"
                        label-class="form-label label-14 d-block text-start" />
                </div>
            </div>

            <div class="text-start">
                <x-form.button type="submit" class="btn btn-sm px-4 mt-3 shadow"
                    style="background-color: #003366; color: white; border: none; box-shadow: 0 4px 16px rgba(0, 51, 102, 0.6); font-size: 14px; padding: 6px 12px;">
                    <span>Calculer</span>
                </x-form.button>
            </div>

            @if (!empty($resultats))
                <div class="mt-4 bg-white p-4 rounded shadow-sm border-0"
                    style="box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);">

                    {{-- Liste des résultats uniquement, sans titre --}}
                    <ul class="list-group list-group-flush mb-3">
                        @foreach ($resultats as $item)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span class="text-muted">{{ $item['label'] }}</span>
                                <strong class="text-dark">{!! $item['val'] !!}</strong>
                            </li>
                        @endforeach
                    </ul>

                    <div class="text-start mt-3">
                        <x-form.button type="button"  style="font-size: 14px"  wire:click="$set('showModal', true)">
                            Générer fiche de paie
                        </x-form.button>
                    </div>
                </div>
            @endif

            <x-form.modal :show="$showModal">
                <form wire:submit.prevent="generatePayslipPdf" class="p-3 mx-auto" style="max-width: 300px;">
                    <div class="modal-dialog" style="max-height: 90vh; overflow-y: auto;">
                        <h2 class="fs-5 fw-bold">Générer la Fiche de Paie</h2>
                    </div>

                    <div class="modal-body p-4">
                        <h6 class="text-left fw-bold">INFORMATION DE L'EMPLOYE</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Période de paie</label>
                                <input type="text" class="form-control" wire:model="periode_paie" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left" style="font-size: 0.85rem;">Nom
                                    de l'employé</label>
                                <input type="text" class="form-control" placeholder="Ex: Jean Dupont"
                                    wire:model="nom_employe">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left" style="font-size: 0.85rem;">Date
                                    d'embauche</label>
                                <input type="date" class="form-control" wire:model="date_embauche">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Poste/Fonction</label>
                                <input type="text" class="form-control" placeholder="Ex: Développeur Web"
                                    wire:model="poste_employe">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left" style="font-size: 0.85rem;">Type
                                    de contrat</label>
                                <input type="text" class="form-control" placeholder="Ex: CDI, CDD, Stage"
                                    wire:model="type_contrat">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left" style="font-size: 0.85rem;">N°
                                    CNSS Employé</label>
                                <input type="text" class="form-control" placeholder="Ex: 123456789"
                                    wire:model="num_cnss_employe">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Numéro IFU</label>
                                <input type="text" class="form-control" placeholder="Ex: 0000000000000"
                                    wire:model="ifu_employe">
                            </div>
                        </div>

                        <h6 class=" text-left fw-bold mt-4">INFORMATION DE L'EMPLOYEUR</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Nom de l'entreprise</label>
                                <input type="text" class="form-control" placeholder="Ex: Votre Entreprise S.A."
                                    wire:model="entreprise">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left" style="font-size: 0.85rem;">N°
                                    CNSS Employeur</label>
                                <input type="text" class="form-control" placeholder="Ex: 987654321"
                                    wire:model="num_cnss_employeur">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Adresse de l'entreprise</label>
                                <input type="text" class="form-control"
                                    placeholder="Ex: 123 Rue de la Paix, Cotonou" wire:model="adresse_entreprise">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold d-block text-left"
                                    style="font-size: 0.85rem;">Numéro IFU</label>
                                <input type="text" class="form-control" placeholder="Ex: 0000000000000"
                                    wire:model="ifu_employeur">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" @click="$wire.set('showModal', false)" class="btn btn-secondary"  style="font-size: 14px">
                                Annuler
                            </button>
                            <button type="submit" wire:click="generatePayslipPdf" class="btn btn-primary"  style="font-size: 14px">
                                Générer PDF
                            </button>
                        </div>
                    </div>
                </form>
            </x-form.modal>
        </form>
    </div>
</div>
