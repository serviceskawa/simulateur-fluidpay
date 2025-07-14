<div> <!-- ✅ Élément racine -->

    <style>
        .nav-link-custom {
            padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid #555;
            color: black;
            text-decoration: none;
            font-weight: bold;
            background-color: white;
            transition: all 0.2s ease;
            display:flex;
            /* white-space: nowrap; */
            text-align: center;
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

        .nav-buttons-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        /* ✅ RESPONSIVE : agrandit la largeur en dessous de 768px */
        @media (max-width: 768px) {
            .nav-buttons-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .nav-link-custom {
                padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid #555;
            color: black;
            text-decoration: none;
            font-weight: bold;
            background-color: white;
            /* transition: all 0.2s ease; */
            /* display:flex; */
            /* white-space: nowrap; */
            text-align: center;

            }



        }

       h1.calcul-title {
    font-family: 'Noto Sans Kawi', sans-serif;
    font-size: 50px;
    font-weight: bold;
    text-align: center;
    margin: 0;
}

/* ✅ RESPONSIVE : en dessous de 992px, on passe à 30px */
@media (max-width: 992px) {
    h1.calcul-title {
        font-size: 30px;
    }
}

@media (max-width: 768px) {
    h1.calcul-title {
        font-size: 30px;
    }
}

@media (max-width: 480px) {
    h1.calcul-title {
        font-size: 30px;
    }
}
/* Par défaut (grands écrans), on cache le <br> */
.responsive-br {
    display: none;
}

/* En responsive (tablette et mobile), on affiche le <br> */
@media (max-width: 768px) {
    .responsive-br {
        display: inline;
    }
}



        .highlight {
            font-weight: 600;

        }
    </style>

    <section class="container  d-flex flex-column align-items-center mt-4">
   <h1 class="calcul-title">
    Calculer le salaire <span class="responsive-br"><br></span>brut/net
</h1>

<div style="max-width: 750px; text-align: center; font-family: 'Noto Sans Kawi', sans-serif; font-size: 18px;">
  <p style="margin-top: 12px;  font-size: 18px;">
    <span>Calculez votre salaire net ou brut</span><br>
    <span>Générez votre fiche de paie PDF.</span>
  </p>

  <p style="  font-size: 18px;">
    Découvrez aussi...
  </p>
</div>

    </section>
    <div class="container" style="max-width: 750px;">
        <!-- Navigation boutons -->
        <div
            class="d-flex justify-content-center align-items-center flex-wrap nav-buttons-responsive gap-4 mb-5 mt-4 ">
             <a href="https://notebooklm.google.com/notebook/4d765894-d017-4199-9964-b15cb406e3d8"
                class="nav-link-custom active " target="_blank" rel="noopener">
                Assistant RH intelligent
            </a>

            <a href="https://site.fluidpay.link/blog/" class="nav-link-custom">Blog</a>



        </div>

        <!-- Contenu principal -->
        <livewire:front-end.salary-calculator-page.normal-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.inverse-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.visitor />
    </div>

</div>
