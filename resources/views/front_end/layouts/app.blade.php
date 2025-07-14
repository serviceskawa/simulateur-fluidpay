<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
        <title>Fluidpay-calculateur</title>
    <meta name="description" content="Calculez votre salaire net à partir du brut ou l'inverse avec notre simulateur FluidPay. Obtenez une fiche de paie PDF gratuite.">

    <!-- SEO meta -->
    <meta name="keywords" content="simulateur salaire, calcul salaire brut, net, fiche de paie PDF, RH, FluidPay">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:title" content="FluidPay - Simulateur de salaire net / brut">
    <meta property="og:description" content="Faites une simulation gratuite de votre salaire net ou brut, puis générez une fiche de paie personnalisée en PDF.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/img/preview.jpg') }}">
    <meta property="og:type" content="website">

      <link rel="icon" href="{{ asset('assets/img/fluidpay_logo.png') }}" type="image/png" sizes="64x64">


      @include('front_end.layouts.partials.stylecss')
   </head>
   <body>
      @include('front_end.layouts.partials.navbar')
      <!-- header section end -->

        {{ $slot }}

      <!-- footer section start -->
      @include('front_end.layouts.partials.footer')
      <!-- footer section end -->

      <!-- copyright section start -->
      @include('front_end.layouts.partials.copywrite')
      <!-- copyright section end -->

      <!-- Javascript files-->
      @include('front_end.layouts.partials.scriptjs')
   </body>
</html>
