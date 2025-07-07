<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche de paie</title>
</head>

<body>
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            font-size: 80%;
            margin: 0;
            padding: 0;
            color: #333;
        }


        .company-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .company-header img {
            max-height: 55px;
            max-width: 160px;
            margin: 0 auto 10px;
            display: block;
            filter: grayscale(100%) brightness(0%);
        }

        .info-grid,
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 0.85em;
        }

        .info-grid td,
        .detail-table td {
            padding: 6px 4px;
            vertical-align: middle;
            color: #333;
        }

        .info-grid .label-col {
            width: 30%;
            font-weight: 600;
            color: #000;
            padding-right: 20px;
        }

        .info-grid .value-col {
            width: 30%;
            font-weight: 500;
            text-align: right;

        }
       



        .detail-table {
            width: 100%;
            margin-bottom: 20px;

            font-size: 0.85em;

        }







        .detail-table td {
            padding: 6px 4px;

            vertical-align: middle;
            color: #333333;
        }




        .detail-table .label-col {
            width: 70%;
        }

        .detail-table .value-col {
            width: 30%;
            text-align: right;
        }

        .highlight-row {
            background: #fff;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .highlight-row td {
            padding: 8px 4px;
            font-weight: 700;
            color: #000;
        }


        .highlight-row .value-col {
            font-size: 1.05em;
        }

        .section-heading {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 15px 0 10px;
            padding-bottom: 4px;
            color: #000;
            border-bottom: 1px solid #000;

        }





        .document-title {
            text-align: center;
            font-size: 1.7em;

            font-weight: 700;
            padding-bottom: 8px;

            color: #000000;

            text-transform: uppercase;
            letter-spacing: 1px;

            border-bottom: 2px solid #000000;

        }

        .detail-table .px {
            border-bottom: 2px solid #000000;

        }



        .signature-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-family: 'Noto Sans', sans-serif;
            font-size: 13px;

        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;

            white-space: nowrap;
        }



        .bold-row td {
            font-weight: bold;
        }

        .bold-row .value-col {
            font-weight: bold;
            font-size: 1.05em;
        }

        .no-bottom-border {
            border-bottom: none !important;
        }


        .signature-name {
            height: 40px;
            margin: 0;
            font-size: 13px;
            display: inline-block;
        }


        .label-col .pe {
            border-bottom: none !important;
            font-weight: bold;
            font-size: 1.05em;

        }

        .ps {
            border-bottom: 1px solid #000;

        }

        .pr {
            margin-top: 8px;
        }

        .signature-block,
        .signature-table {
            page-break-inside: avoid;
            break-inside: avoid;
        }


        @media print {
            .payslip-container {
                box-shadow: none;
                margin: 0;
                padding: 15mm 20mm;
            }
        }
    </style>
    <div class="payslip-container">
        <div class="company-header">

            <h3>{{ $entreprise ?? 'NOM ENTREPRISE' }}</h3>
            <p>{{ $adresse_entreprise ?? 'ADRESSE ENTREPRISE' }}</p>
            <p>IFU : {{ $ifu_employeur ?? 'XXXXXXXXXX' }} | CNSS : {{ $num_cnss_employeur ?? 'XXXXXXXXXX' }}</p>
        </div>

        <h2 class="document-title">BULLETIN DE PAIE - {{ $periode_paie ?? 'MOIS ANNEE' }}</h2>

<table class="info-grid">
    <tbody>
        <tr>
            <td class="label-col"><strong>Employé :</strong></td>
            <td class="value-col">{{ $nom_employe ?? 'NOM EMPLOYE' }}</td>

            <td style="width: 20px;"></td> <!-- colonne vide pour espacement -->

            <td class="label-col"><strong>Poste/Fonction :</strong></td>
            <td class="value-col">{{ $poste_employe ?? 'POSTE' }}</td>
        </tr>
        <tr>
            <td class="label-col"><strong>Date d'embauche :</strong></td>
            <td class="value-col">{{ $date_embauche ?? 'DATE' }}</td>

            <td></td> <!-- colonne vide -->

            <td class="label-col"><strong>Type de contrat :</strong></td>
            <td class="value-col">{{ $type_contrat ?? 'TYPE' }}</td>
        </tr>
        <tr>
            <td class="label-col"><strong>N° CNSS Employé :</strong></td>
            <td class="value-col">{{ $num_cnss_employe ?? 'XXXXXXXXXX' }}</td>

            <td></td> <!-- colonne vide -->

            <td class="label-col"><strong>N° IFU :</strong></td>
            <td class="value-col">{{ $ifu_employe ?? 'XXXXXXXXXX' }}</td>
        </tr>
    </tbody>
</table>


        <div class="section-heading">DETAIL SUR LE SALAIRE</div>
        <table class="detail-table">
            @php
                $salaireBase = collect($resultats)->first(function ($item) {
                    return str_contains(strtolower($item['label']), 'base');
                });

                $salaireBrut = collect($resultats)->first(function ($item) {
                    return str_contains(strtolower($item['label']), 'brut');
                });
            @endphp


            <tr>
                <td class="label-col">Salaire de base contractuel</td>
                <td class="value-col">
                    {{ $salaireBrut['val'] ?? ($salaire_brut ? number_format($salaire_brut, 0, ',', ' ')   : 'MONTANT') }}
                </td>
            </tr>



            <tr class="bold-row">
                <td class="label-col">SALAIRE BRUT</td>
                <td class="value-col">
                    {{ $salaireBrut['val'] ?? ($salaire_brut ? number_format($salaire_brut, 0, ',', ' ')  : 'MONTANT') }}
                </td>

            </tr>
        </table>



        <div class="section-heading">Retenues obligatoires</div>
        <table class="detail-table">
            <tbody>
                @foreach ($resultats as $item)
                    @php
                        $label = strtolower($item['label']);


                        if (strpos($label, 'cnss ouvrière') !== false) {
                            $libelle = 'Charge Soc. Employé';
                        } elseif (strpos($label, 'impôt') !== false) {
                            $libelle = 'ITS';
                        } elseif (strpos($label, 'salaire net') !== false) {
                            $libelle = 'SALAIRE NET';
                        } else {
                            $libelle = $item['label'];
                        }
                    @endphp

                    @if (strpos($label, 'cnss ouvrière') !== false ||
                            strpos($label, 'impôt') !== false ||
                            strpos($label, 'taxe') !== false ||
                            strpos($label, 'salaire net') !== false)
                        <tr class="{{ strpos($label, 'salaire net') !== false ? 'bold-row no-bottom-border' : '' }}">
                            <td class="label-col">{{ $libelle }}</td>
                            <td class="value-col">{{ $item['val'] }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>



        <div class="section-heading" style="margin-bottom: 6px;">Autres retenues</div>
        <table class="detail-table">
            <tbody>

                <tr>
                    <td class="label-col">Acompte</td>
                    <td class="value-col">0</td>
                </tr>
                <tr>
                    <td class="label-col">Oppositions</td>
                    <td class="value-col">0</td>
                </tr>



                @foreach ($resultats as $item)
                    @php $label = strtolower($item['label']); @endphp
                    @if (strpos($label, 'salaire net') !== false)
                        <tr class="bold-row ">
                            <td class="label-col">{{ strtoupper($item['label']) }}</td>
                            <td class="value-col">{{ $item['val'] }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>




        <div class="section-heading">autres charges</div>
        <table class="detail-table">
            <tbody>
                @php
                    $cnssPatronale = collect($resultats)->first(function ($item) {
                        return str_contains(strtolower($item['label']), 'cnss patronale');
                    });

                    $vps = collect($resultats)->first(function ($item) {
                        return str_contains(strtolower($item['label']), 'vps');
                    });
                @endphp

                @if ($cnssPatronale)
                    <tr>
                        <td class="label-col">Charge Soc. Employeur</td>
                        <td class="value-col">{{ $cnssPatronale['val'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="label-col">Charge Soc Employeur X.X%</td>
                        <td class="value-col">MONTANT</td>
                    </tr>
                @endif

                @if ($vps)
                    <tr>
                        <td class="label-col">{{ $vps['label'] }}</td>
                        <td class="value-col">{{ $vps['val'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="label-col">VPS X%</td>
                        <td class="value-col">MONTANT</td>
                    </tr>
                @endif
                <tr class="bold-row ">
                    <td class="label-col">COÛT TOTAL POUR L'EMPLOYEUR</td>
                    <td class="value-col">
                        {{ isset($coutTotalEmployeur) ? number_format($coutTotalEmployeur, 0, ',', ' ')   : 'MONTANT' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>




      <div class="section-heading"></div>


    <table style="width: 100%;" class="pr">
        <tr>
            <td style="width: 50%; text-align: left;">
                <p><strong>L'EMPLOYE</strong></p>
                <div class="signature-name"></div>
            </td>
           <td style="width: 50%; text-align: right;">
                <p><strong>L'EMPLOYEUR</strong></p>
                <div class="signature-name"></div>
            </td>

        </tr>
    </table>


    </div>

    </div>


</body>

</html>
