<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Fiche de Paie - {{ $nom_employe }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>FICHE DE PAIE</h2>

    <div class="section">
        <strong>Période de paie :</strong> {{ $periode_paie }}<br>
        <strong>Date de paiement :</strong> {{ $date_paiement }}<br>
    </div>

    <div class="section">
        <h3>Employé</h3>
        <p>Nom : {{ $nom_employe }}</p>
        <p>Date d'embauche : {{ $date_embauche }}</p>
        <p>Type de contrat : {{ $type_contrat }}</p>
        <p>Poste / Fonction : {{ $poste_fonction }}</p>
        @if($date_fin_contrat)
            <p>Date de fin contrat : {{ $date_fin_contrat }}</p>
        @endif
        <p>N° CNSS Employé : {{ $cnss_employe }}</p>
    </div>

    <div class="section">
        <h3>Entreprise</h3>
        <p>Nom : {{ $nom_entreprise }}</p>
        <p>Adresse : {{ $adresse_entreprise }}</p>
        <p>N° CNSS Employeur : {{ $cnss_employeur }}</p>
        <p>Numéro IFU : {{ $numero_ifu }}</p>
    </div>

    <div class="section">
        <h3>Détails du Salaire</h3>
        <table>
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resultats as $libelle => $montant)
                    <tr>
                        <td>{{ $libelle }}</td>
                        <td>{{ number_format($montant, 0, ',', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
