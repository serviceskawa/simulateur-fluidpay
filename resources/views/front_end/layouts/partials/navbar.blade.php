<div class="bg-white shadow-sm fs-6" style="min-height: 60px; font-family: 'Noto Sans', sans-serif;">
    <style>
        .nav-link:hover,
        .otn:hover {
            font-style: italic;
            color: #273584;
        }

        .demo-btn:hover {
            transform: skewX(-10deg);
            background-color: #001f4d;
            font-style: normal;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Responsive styles */
        @media (max-width: 991.98px) {
            .container.d-flex {
                flex-direction: column;
                align-items: center !important;
                text-align: center;
                gap: 10px;
            }

            ul.nav.mx-auto {
                flex-direction: column !important;
                align-items: center !important;
                gap: 10px;
                margin-top: 10px;
            }

            ul.nav li {
                margin-right: 0 !important;
            }

            .demo-btn {
                width: 100%;
                max-width: 300px;
                margin-top: 10px;
            }
        }

        @media (max-width: 575.98px) {
            .nav-link {
                font-size: 14px !important;
            }

            .demo-btn {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>

    <div class="container d-flex align-items-center justify-content-between flex-wrap" style="min-height: 60px;">
        <a href="#" class="d-flex align-items-center me-2" style="height: 100%;">
            <img src="{{ asset('assets/img/fluidpay_logo.png') }}" alt="Logo" style="max-height: 100px;">
        </a>

        <ul class="nav mx-auto align-items-center mb-0 flex-nowrap">
            <li class="nav-item me-5">
                <a class="nav-link text-dark" style="font-size: 16px;" href="https://site.fluidpay.link/">Accueil</a>
            </li>
            <li class="nav-item me-5">
                <a class="nav-link text-dark" style="font-size: 16px;" href="https://site.fluidpay.link/#fonctionnalites">Fonctionnalités</a>
            </li>
            <li class="nav-item dropdown me-5">
                <a class="nav-link text-dark d-flex align-items-center" style="font-size: 16px;" href="#" id="ressourceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Ressources
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-1 bi bi-caret-down-fill" viewBox="0 0 16 16">
                        <path d="M7.247 11.14l-4.796-5.481A.5.5 0 0 1 2.5 5h11a.5.5 0 0 1 .384.82l-4.796 5.48a.5.5 0 0 1-.768 0z"/>
                    </svg>
                </a>
                <ul class="dropdown-menu shadow-sm border-0 rounded-3 mt-2 py-2" style="min-width: 220px;">
                    <li><a class="dropdown-item py-2 px-3" href="https://site.fluidpay.link/blog/">Blog</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 px-3" href="https://site.fluidpay.link">Calculateur de salaire</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item py-2 px-3" href="https://notebooklm.google.com/notebook/4d765894-d017-4199-9964-b15cb406e3d8">Assistant RH intelligent</a></li>
                </ul>
            </li>
            <li class="nav-item me-5">
                <a class="nav-link text-dark" style="font-size: 16px;" href="https://crm.fluidpay.link/forms/quote/4a3d5cf45c821ae6a1095184c2bc2042?styled=1&with_logo=1">Contact</a>
            </li>
        </ul>

        <a href="https://crm.fluidpay.link/forms/wtl/90c59c34eb649f5ffc229dcab952ec21?styled=1&with_logo=1" class="otn btn-sm text-white ms-2 demo-btn"
           style="background-color: #273584; border-radius: 28px; padding: 10px 20px; min-width: 250px; font-size: 16px; line-height: 1.2; text-align: center; font-style: normal; transition: all 0.3s ease; display: inline-block;">
            Demander une démo
        </a>
    </div>
</div>
