<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ajout important -->
    <title>Simulateur Salaire</title>

    @livewireStyles

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Roboto Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        h1 {
            font-weight: 600;
        }

        .section-block {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 576px) {
            .section-block {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-5 text-center">Simulateur de Salaire</h1>

        <!-- Section Calcul Salaire Brut -->
        {{--  <div class="section-block mb-4">--}}
            <livewire:calcul-salaire />
        </div>

        <!-- Section Calcul Salaire Net -->
        {{-- <div class="section-block mt-4"> --}}
            <livewire:calcul-salaire-net />
        </div>
    </div>
  <br>
  <br>
    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
