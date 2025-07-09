<div> <!-- ✅ Élément racine ajouté -->


<style>
    .nav-link-custom {
        padding: 10px 20px;
        border-radius: 25px;
        border: 1px solid #555;       /* Gris foncé plus doux */
        color: #555;                  /* Texte gris foncé */
        text-decoration: none;
        font-weight: bold;
        background-color: white;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .nav-link-custom:hover {
        transform: scale(1.05);       /* Agrandit légèrement le bouton */
        border-width: 2px;            /* Épaissit la bordure */
        color: #555;                  /* Conserve la même couleur de texte */
        background-color: white;      /* Pas de changement de fond */
    }

    .nav-link-custom.active {
        background-color: #273584;    /* Bleu nuit pour l’actif */
        color: white;
        border-color: #273584;
        transform: none;
    }

    html {
        scroll-behavior: smooth;
    }
</style>




  <div class="container" style="max-width: 750px;  ">
    <div class="d-flex justify-content-between align-items-center p-2  mb-5  mt-5  ">
        <a href="#simulateur" class="nav-link-custom active">Simulateur</a>
        <a href="https://site.fluidpay.link/blog/" class="nav-link-custom">Blog</a>
        <a href="https://notebooklm.google.com/notebook/4d765894-d017-4199-9964-b15cb406e3d8" class="nav-link-custom">Assistant RH intelligent</a>
    </div>





        <livewire:front-end.salary-calculator-page.normal-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.inverse-calculator-salary-page />
        <livewire:front-end.salary-calculator-page.visitor />

</div>

</div>
