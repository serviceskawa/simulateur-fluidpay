<style>
  .footer-title {
    color: #9CA3AF;
  }

  .footer-link {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 12px;
  }

  .footer-link:hover {
    color: #9CA3AF;
    text-decoration: none;
  }
  .small{

    font-size: 12px;
  }
</style>

<footer class="bg-dark text-light py-5 mt-5" role="contentinfo">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-3 d-flex flex-column align-items-start">
        <div class="mb-3">
          <a href="#" class="d-inline-block">
            <img src="{{ asset('assets/img/fluidpay_logos.png') }}" alt="Logo" style="max-height: 80px;">
          </a>
        </div>
        <p class="small mb-0">
          <strong>Sèdomey</strong><br>
          Godomey, Abomey-Calavi<br>
          Atlantique, Bénin<br>
          —<br>
          <strong>FluidPay</strong> est une solution proposée par <strong>KAWA SERVICES</strong>.<br>
          Contact :
          <a href="mailto:support@fluidpay.link" class="footer-link fw-bold">support@fluidpay.link</a>
        </p>
      </div>
      <div class="col-md-3">
        <h5 class="fw-bold mb-3 footer-title">Entreprise</h5>
        <ul class="list-unstyled">
          <li><a href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1" target="_blank" class="footer-link">Nous rejoindre</a></li>
          <li><a href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1" target="_blank" class="footer-link">Contact</a></li>
          <li><a href="https://site.fluidpay.link/terms-of-service/" class="footer-link">Conditions générales d'utilisation</a></li>
          <li><a href="https://site.fluidpay.link/privacy-policy/" class="footer-link">Politique de confidentialité</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="fw-bold mb-3 footer-title">Produit</h5>
        <ul class="list-unstyled">
          <li><a href="https://crm.fluidpay.link/forms/wtl/a2a382e0ebe26c3e4696bbafb7dd4468?styled=1&with_logo=1." target="_blank" class="footer-link">Essayer FluidPay gratuitement</a></li>
          <li><a href="https://site.fluidpay.link/" class="footer-link">Caractéristiques</a></li>
          <li><a href="https://panel.fluidpay.link/login" target="_blank" class="footer-link">Connexion</a></li>
        </ul>
      </div>
      <div class="col-md-3" style="font-size: 12px;">
        <h5 class="fw-bold mb-3 footer-title">Pays</h5>
        <ul class="list-unstyled">
          <li><span class="text-light">Bénin</span></li>
          <li><span class="text-light">Togo (bientôt)</span></li>
        </ul>
      </div>

    </div>
  </div>
</footer>
