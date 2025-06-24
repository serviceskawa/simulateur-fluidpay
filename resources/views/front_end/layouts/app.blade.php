<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>{{ $title ?? 'FLUIDPAY' }}</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
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
