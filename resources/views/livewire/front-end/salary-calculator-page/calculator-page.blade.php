<div> <!-- ✅ Élément racine -->

    <style>
        .nav-link-custom {
            padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid #555;
            color: #555;
            text-decoration: none;
            font-weight: bold;
            background-color: white;
            transition: all 0.2s ease;
            display: inline-block;
            white-space: nowrap;
        }

        .nav-link-custom:hover {
            transform: scale(1.05);
            border-width: 2px;
            color: #555;
            background-color: white;
        }

        .nav-link-custom.active {
            background-color: #273584;
            color: white;
            border-color: #273584;
            transform: none;
        }

        html {
            scroll-behavior: smooth;
        }

        @media (max-width: 768px) {
            .nav-buttons-responsive {
                flex-direction: column !important;
                gap: 10px !important;
                text-align: center;
            }
        }
    </style>

    <div class="container" style="max-width: 750px;">
        <!-- Navigation boutons -->
        <div class="d-flex justify-content-between align-items-center flex-wrap nav-buttons-responsive gap-2 p-2 mb-4 mt-4">
            <a href="#simulateur" class="nav-link-custom active">Simulateur</a>
            <a href="https://site.fluidpay.link/blog/" class="nav-link-custom">Blog</a>
            <a href="https://notebooklm.google.com/notebook/4d765894-d017-4199-9964-b15cb406e3d8" class="nav-link-custom">Assistant RH intelligent</a>
        </div>

        <!-- Contenu principal -->
        <livewire:front-end.salary-calculator-page.normal-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.inverse-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.visitor />
    </div>

</div>
