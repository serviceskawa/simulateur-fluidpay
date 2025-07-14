<style>
  .footer {
    background-color: #111416;
    color: #fff;
    padding: 60px 0;
    font-family: 'Noto Sans', sans-serif;
  }

  .footer .footer-title {
    color: #9CA3AF;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
  }


  .footer .col-md-3 {
  margin-top: 0 !important;
}

.footer .col-md-3:first-child {
  display: flex;
  flex-direction: column;
  justify-content: start;
}


  .footer .footer-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 12px;
    transition: color 0.3s ease;
    display: block;
    margin-bottom: 8px;

  }

  .footer .footer-link:hover {
    color: #9CA3AF;
  }

  .footer .footer-text {
    font-size: 12px;
    color: #9CA3AF;
    line-height: 1.6;
  }

  .footer a.footer-link-inline {
    color: #9CA3AF;
    text-decoration: none;
  }

  .footer a.footer-link-inline:hover {
    color: #ffffff;
  }

  @media (max-width: 767.98px) {
    .footer .row {
      display: flex;
      flex-wrap: wrap;
      gap: 0;
    }

    .footer .col-md-3 {
      width: 50%;
      padding: 10px;
    }

    .footer .footer-title {
      font-size: 16px;
    }

    .footer .footer-link {
      font-size: 12px;
    }

    .footer .footer-text {
      font-size: 12px;
    }
    .footer .col-md-3.align-items-start {
    padding-left: 15px;
    padding-right: 15px;

  }




  .footer .col-md-3 .footer-text {
    padding-left: 0 !important;
    margin-left: 0 !important;
  }




  .footer .col-md-3 {
  width: 50%;
  padding: 10px 15px;
  box-sizing: border-box;
}

/* Corriger l'alignement du logo */
.footer .col-md-3:first-child {
  margin-top: 15px; /* Donne le même espace vertical que les autres */
  padding-left: 15px;
  padding-right: 15px;
}

/* Corriger l'image du logo */
.footer .col-md-3:first-child a img {
  display: block;
  margin-left: 0;
  padding-left: 0;
  max-width: 100%;
}


   .footer .col-md-3:first-child a img {
    display: block;
    max-width: 100%;
  }
  }
</style>




<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="row gy-4">
      <!-- Logo + Contact -->
      <div class="col-md-3 d-flex flex-column align-items-start">


        <div class="mb-1">
          <a href="#" class="d-inline-block">
            <img src="{{ asset('assets/img/fluidpay_logos.png') }}" alt="Logo" style="max-height: 80px;">
          </a>
        </div>
        <p class="footer-text mb-0 fw-bold">
          <strong>Sèdomey</strong><br>
          Godomey, Abomey-Calavi<br>
          Atlantique, Bénin<br>
          —<br>
          <strong>FluidPay</strong> est une solution proposée par <strong>KAWA SERVICES</strong>.
           Pour en savoir plus ou pour toute question, contactez-nous par email
          <a href="mailto:support@fluidpay.link" class="footer-link-inline">support@fluidpay.link</a>
          Nous <br> sommes à votre disposition !
        </p>
      </div>

      <!-- Entreprise -->
      <div class="col-md-3">
        <h5 class="footer-title " style="margin-top: 15px">Entreprise</h5>
        <ul class="list-unstyled">
          <li><a href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1" class="footer-link" target="_blank">Nous rejoindre</a></li>
          <li><a href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1" class="footer-link" target="_blank">Contact</a></li>
          <li><a href="https://site.fluidpay.link/terms-of-service/" class="footer-link">Conditions générales</a></li>
          <li><a href="https://site.fluidpay.link/privacy-policy/" class="footer-link">Politique de confidentialité</a></li>
        </ul>
      </div>

      <!-- Produit -->
      <div class="col-md-3">
        <h5 class="footer-title" style="margin-top: 15px">Produit</h5>
        <ul class="list-unstyled">
          <li><a href="https://crm.fluidpay.link/forms/wtl/a2a382e0ebe26c3e4696bbafb7dd4468?styled=1&with_logo=1" class="footer-link" target="_blank">Essayer gratuitement</a></li>
          <li><a href="https://site.fluidpay.link/" class="footer-link">Caractéristiques</a></li>
          <li><a href="https://panel.fluidpay.link/login" class="footer-link" target="_blank">Connexion</a></li>
        </ul>
      </div>

      <!-- Pays -->
      <div class="col-md-3">
        <h5 class="footer-title" style="margin-top: 15px">Pays</h5>
        <ul class="list-unstyled">
          <li class="text-light " style="font-size: 12px;">Bénin</li>
          <li class="text-light" style="font-size: 12px;">Togo (bientôt)</li>
        </ul>
      </div>
    </div>
  </div>
</footer>
