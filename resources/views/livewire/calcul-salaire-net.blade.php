<div>
    {{-- Formulaire Calcul Salaire Net --}}
    <form wire:submit.prevent="calculerInverse" class="card p-3 shadow-sm" style="max-width: 700px; margin: auto;">
        <h4 class="mb-3">Calcul salaire Net</h4>

        <div class="row g-2 mb-2">
            <div class="col">
                <x-form.input name="salaire_net" label="Salaire Net (FCFA)" type="number" wire:model="salaire_net" placeholder="Ex: 200000" />
            </div>
            <div class="col">
                <x-form.select name="mois_inverse" label="Mois de la paie"
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
                />
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div class="col">
                <x-form.input name="cnss_ouvriere" label="CNSS Ouvrière (%)" type="number" step="0.1" wire:model="cnss_ouvriere" />
            </div>
            <div class="col">
                <x-form.input name="cnss_patronale" label="CNSS Patronale (%)" type="number" step="0.1" wire:model="cnss_patronale" />
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-6">
                <x-form.input name="vps" label="VPS (%)" type="number" wire:model="vps" />
            </div>
        </div>

        <x-form.button type="submit" class="btn-primary btn-sm px-2" style="max-width: 70px">
            Calculer
        </x-form.button>

        @if (!empty($resultats))
        <div class="mt-3 card p-3 shadow-sm mb-4">
            <h6>Résultats - {{ $type_calcul === 'brut' ? $mois_brut : $mois_inverse }}</h6>
            <ul class="list-group list-group-flush">
                @foreach ($resultats as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item['label'] }}</span>
                        <span>{!! $item['val'] !!}</span>
                    </li>
                @endforeach
            </ul>
             <x-form.button type="button" class="btn-success btn-sm mt-3" wire:click="$set('showModal', true)">
            Générer fiche de paie
        </x-form.button>

        </div>
        @endif
    </form>

    {{-- Bouton pour ouvrir le modal --}}



    {{-- Modal fiche de paie --}}
    <x-form.modal :show="$showModal">
        <form wire:submit.prevent="generatePayslipPdf" class="space-y-4">
            <h2 class="text-xl font-bold text-center mb-4">Générer la Fiche de Paie</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.input name="periode_paie" label="Période de paie" placeholder="Ex: Juin 2025" wire:model.defer="periode_paie" />
                <x-form.input name="date_paiement" type="date" label="Date de paiement" wire:model.defer="date_paiement" />

                <x-form.input name="nom_employe" label="Nom de l'employé" placeholder="Ex: Jean Dupont" wire:model.defer="nom_employe" />
                <x-form.input name="date_embauche" type="date" label="Date d'embauche" wire:model.defer="date_embauche" />

                <x-form.input name="type_contrat" label="Type de contrat" placeholder="Ex: CDI, CDD, Stage" wire:model.defer="type_contrat" />
                <x-form.input name="cnss_employe" label="N° CNSS Employé" placeholder="Ex: 123456789" wire:model.defer="cnss_employe" />

                <x-form.input name="cnss_employeur" label="N° CNSS Employeur" placeholder="Ex: 987654321" wire:model.defer="cnss_employeur" />
                <x-form.input name="nom_entreprise" label="Nom de l'entreprise" placeholder="Ex: Votre Entreprise S.A." wire:model.defer="nom_entreprise" />

                <x-form.input name="adresse_entreprise" label="Adresse de l'entreprise" placeholder="Ex: 123 Rue de la Paix, Cotonou, Bénin" wire:model.defer="adresse_entreprise" class="md:col-span-2" />

                <x-form.input name="poste" label="Poste/Fonction" placeholder="Ex: Développeur Web" wire:model.defer="poste" />
                <x-form.input name="date_fin_contrat" type="date" label="Date de fin de contrat (facultatif)" wire:model.defer="date_fin_contrat" />

                <x-form.input name="ifu" label="Numéro IFU" placeholder="Ex: 0000000000000" wire:model.defer="ifu" />

                <div class="md:col-span-1">
                    <label for="logo_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Logo de l'entreprise</label>
                    <input type="file" id="logo_entreprise" wire:model="logo_entreprise" accept="image/*" class="w-full border p-2 rounded">
                </div>

                <div class="md:col-span-1">
                    <label for="signature_employeur" class="block text-sm font-medium text-gray-700 mb-1">Signature Employeur (Image)</label>
                    <input type="file" id="signature_employeur" wire:model="signature_employeur" accept="image/*" class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <x-form.button type="button" class="bg-gray-500 hover:bg-gray-700" wire:click="closeModal">
                    Annuler
                </x-form.button>
                <x-form.button type="submit" class="bg-blue-600 hover:bg-blue-800">
                    Générer PDF
                </x-form.button>
            </div>
        </form>
    </x-form.modal>
</div>
