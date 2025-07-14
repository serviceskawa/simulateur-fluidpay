<div class="bg-white shadow-sm fs-6" style="font-family: 'Noto Sans', sans-serif; ">

    <style>
        .nav-link:hover,
        .otn:hover {
            font-style: italic;
            color: #273584;
        }

        .demo-btn:hover {
            transform: skewX(-10deg);
            background-color: #001f4d;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Hamburger styles */
        .navbar-toggler {
            display: none; /* Cacher par défaut */
            background: none;
            border: none;
            cursor: pointer;
        }

       .bar {
    display: block;
    width: 20px;
    height: 3px;
    margin: 3px auto;
margin-right: 15px;

    background-color: black;
    transition: all 0.3s ease-in-out;
}

.navbar-toggler.active .bar:nth-child(1) {
    transform: rotate(45deg) translate(4px, 4px);
    text-align: center;
}

.navbar-toggler.active .bar:nth-child(2) {
    opacity: 0;
}

.navbar-toggler.active .bar:nth-child(3) {
    transform: rotate(-45deg) translate(4px, -4px);
    text-align: center;
}
.navbar-toggler.active .bar:nth-child(4) {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 75%;
    height: 85%;

    border: 3px solid black;
    text-align: center;
    background: none;
    z-index: -1;
    padding-bottom: 8px;
}

 .navbar-toggler.active {
     position: relative;
    width: 40px;
    height: 40px;



    align-items: center;
    justify-content: center;
    padding: 0;
    background-color: transparent;
    z-index: 10;



}






        /* Responsive styles */
        @media (max-width: 1200px) {
            .navbar-toggler {
                display: block;
                margin-left: auto;
                margin-top: 0;
            }

            #mainNav {
                display: none;
                flex-direction: column !important;
                align-items: flex-end !important;
                text-align: right;
                width: 100%;
                gap: 10px;
                margin-top: 10px;
            }

             .dropdown-menu hr {
    display: block; /* Montre les <hr> */
    margin: 6px 0;
    border-color: #eee;
  }

            #mainNav.show {
                display: flex;
            }

            .demo-btn {
                width: 100%;
                max-width: 300px;
                background-color: transparent !important;
                color: black !important;

            }

            #mainNav li {
                width: 100%;
                display: flex;
                justify-content: flex-end;
            }
               h1 {
    font-size: 28px;
  }



        }
    </style>

    <div class="container d-flex align-items-center justify-content-between flex-wrap" style="min-height: 40px;">
        <!-- Logo -->
        <a href="#" class="d-flex align-items-center" style="height: 100%;">
            <img src="{{ asset('assets/img/fluidpay_logo.png') }}" alt="Logo" style="max-height: 100px;">
        </a>

        <!-- Hamburger icon (visible seulement en responsive) -->
        <button id="hamburgerBtn" class="navbar-toggler" type="button" onclick="toggleNavbar()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>

        </button>

        <!-- Navigation menu -->
        <ul id="mainNav" class="nav mx-auto align-items-center mb-0 flex-nowrap">
            <li class="nav-item me-5">
                <a class="nav-link text-dark" href="https://site.fluidpay.link/">Accueil</a>
            </li>
            <li class="nav-item me-5">
                <a class="nav-link text-dark" href="https://site.fluidpay.link/#fonctionnalites">Fonctionnalités</a>
            </li>
            <li class="nav-item dropdown me-5">
                <a class="nav-link text-dark d-flex align-items-center" href="#" id="ressourceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ressources
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-1 bi bi-caret-down-fill" viewBox="0 0 16 16">
                        <path d="M7.247 11.14l-4.796-5.481A.5.5 0 0 1 2.5 5h11a.5.5 0 0 1 .384.82l-4.796 5.48a.5.5 0 0 1-.768 0z"/>
                    </svg>
                </a>
                <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 py-2" style="min-width: 220px;">
                    <li><a class="dropdown-item py-2 px-3" href="https://site.fluidpay.link/blog/">Blog</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 px-3" href="{{ url('/') }}">Calculateur de salaire</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 px-3" href="https://notebooklm.google.com/notebook/4d765894-d017-4199-9964-b15cb406e3d8">Assistant RH intelligent</a></li>
                </ul>
            </li>
            <li class="nav-item me-5">
                <a class="nav-link text-dark" href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1">Contact</a>
            </li>

            <!-- Bouton Démo (affiché en responsive aussi) -->
            <li class="nav-item">
               <a href="https://crm.fluidpay.link/forms/wtl/90c59c34eb649f5ffc229dcab952ec21?styled=1&with_logo=1"
   class="otn btn-sm text-white demo-btn"
   style="background-color: #273584; border-radius: 28px; padding: 10px 16px; min-width: 210px; font-size: 16px; line-height: 1.6; text-align: center; font-style: normal; transition: all 0.3s ease; display: inline-block;">
    Demander une démo
</a>

            </li>
        </ul>
    </div>

    <!-- JavaScript pour le toggle -->
    <script>
        function toggleNavbar() {
            const nav = document.getElementById('mainNav');
            const btn = document.getElementById('hamburgerBtn');
            nav.classList.toggle('show');
            btn.classList.toggle('active');
        }
    </script>
</div>
