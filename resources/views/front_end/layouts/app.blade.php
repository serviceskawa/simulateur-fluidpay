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
      <!-- site metas -->
      <title>FLUIDPAY</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>



      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

      <script defer src="https://unpkg.com/alpinejs" ></script>
      <!-- Bootstrap Bundle JS (inclut Popper.js) -->


      @include('front_end.layouts.partials.stylecss')
   </head>
   <body>
      @include('front_end.layouts.partials.navbar')
      <!-- header section end -->


  {{-- Input texte --}}
        <x-form.input name="firstname" label="Prénom" placeholder="Ex: Jean" />

        {{-- Input email --}}
        <x-form.input name="email" label="Email" type="email" placeholder="Ex: jean@gmail.com" />

        {{-- Input number --}}
        <x-form.input name="age" label="Âge" type="number" placeholder="Ex: 25" />

        {{-- Textarea --}}
        <x-form.textearea name="bio" label="Biographie" placeholder="Écris quelque chose sur toi..." />

        {{-- Select --}}
        <x-form.select name="role" label="Rôle" :options="['admin' => 'Administrateur', 'user' => 'Utilisateur']" />

        {{-- Checkbox --}}
        <x-form.checkbox name="terms" label="Accepter les conditions" />

        {{-- Bouton submit --}}
        <x-form.button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane me-2"></i>Envoyer
        </x-form.button>
    </form>

<!-- Bouton pour ouvrir le modal -->
<!-- Bouton pour ouvrir la modale -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Ouvrir la modale
</button>

<!-- Appel du composant -->
<x-form.modal id="exampleModal" title="Titre de la modale">
    <p>Voici le contenu principal de la modale.</p>

    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Enregistrer</button>
    @endslot
</x-form.modal>



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
