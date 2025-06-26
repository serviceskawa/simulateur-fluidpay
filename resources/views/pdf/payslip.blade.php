<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Paie</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Fiche de Paie - {{ $periode_paie }}</h1>

    <table>
        <tbody>
            <tr><th>Champ</th><th>Valeur</th></tr>
            <tr><td>Période de paie</td><td>{{ $periode_paie }}</td></tr>
            <tr><td>Date de paiement</td><td>{{ $date_paiement }}</td></tr>
            <tr><td>Nom de l'employé</td><td>{{ $nom_employe }}</td></tr>
            <tr><td>Salaire brut estimé</td><td>{{ $resultats[0]['val'] ?? '' }}</td></tr>
            <tr><td>CNSS Ouvrière</td><td>{{ $resultats[1]['val'] ?? '' }}</td></tr>
            <tr><td>Impôt sur salaire</td><td>{{ $resultats[2]['val'] ?? '' }}</td></tr>
            <tr><td>Salaire net à payer</td><td>{{ $resultats[4]['val'] ?? '' }}</td></tr>
            <!-- Ajoute d'autres champs pertinents ici -->
        </tbody>
    </table>

    <p style="text-align:center;">Merci pour votre confiance.</p>
</body>
</html>
