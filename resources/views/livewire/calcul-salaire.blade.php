<form wire:submit.prevent="calculer" class="card p-3 shadow-sm" style="max-width: 700px; margin: auto;">
    <h4 class="mb-3">Calcul salaire Brut</h4>

    <div class="row g-2 mb-2">
        <div class="col">
            <x-form.input name="salaire_brut" label="Salaire Brut (FCFA)" type="number" wire:model="salaire_brut" placeholder="Ex: 250000" />
        </div>
        <div class="col">
            <x-form.select
                name="mois_brut" label="Mois de paie"
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
            />
        </div>
    </div>

    <div class="row g-2 mb-2">
        <div class="col">
            <x-form.input name="cnss_ouvriere_brut" label="CNSS Ouvrière (%)"  type="number" step="0.1" wire:model="cnss_ouvriere_brut" />
        </div>
        <div class="col">
            <x-form.input name="cnss_patronale_brut" label="CNSS Patronale (%)" type="number"  step="0.1"  wire:model="cnss_patronale_brut" />
        </div>
    </div>
     <div class="col-6">
    <x-form.input name="vps_brut" label="VPS (%)" type="number" wire:model="vps_brut"  />
    </div>
<x-form.button type="submit" class="btn-primary btn-sm px-2 d-flex align-items-center justify-content-center" style="max-width: 120px" wire:loading.attr="disabled">
    <span wire:loading.remove wire:target="calculer">
        Calculer
    </span>


</x-form.button>


   @if ($resultats)
    <div class="mt-3 card p-3 shadow-sm mb-4">
        <h6>Résultats - {{ $mois_brut }}</h6>
        <table class="table table-sm">
            <tbody>
                @foreach ($resultats as $item)
                    <tr>
                        <td>{{ $item['label'] }}</td>
                        <td class="text-end">{{ $item['val'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <x-form.button type="button" class="btn-success btn-sm mt-3" wire:click="$set('showModal', true)">
            Générer fiche de paie
        </x-form.button>

    </div>
@endif


</form>

