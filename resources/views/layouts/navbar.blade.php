<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
    <div class="container-fluid px-4">

        {{-- =========================
            LOGO
        ========================== --}}
        <a href="{{ url('/') }}" class="navbar-brand brand-logo">
            <img src="{{ asset('images/smk.png') }}"
                 alt="Logo SMK"
                 width="38"
                 height="38"
                 class="logo-img">

            <span>POS</span>
        </a>


        {{-- =========================
            TOMBOL MOBILE
        ========================== --}}
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        {{-- =========================
            MENU NAVBAR
        ========================== --}}
        <div class="collapse navbar-collapse"
             id="navbarNav">

            <ul class="navbar-nav ms-4 gap-2">


                {{-- DASHBOARD --}}
                <li class="nav-item">

                    <a href="{{ url('/') }}"
                       class="nav-link
                       {{ Request::is('/') ? 'active' : '' }}">

                        <i class="bi bi-house-door-fill me-1"></i>
                        Dashboard

                    </a>

                </li>


                {{-- USER --}}
                @if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')

                    <li class="nav-item">

                        <a href="{{ route('users.index') }}"
                           class="nav-link
                           {{ Request::is('users*') ? 'active' : '' }}">

                            <i class="bi bi-people-fill me-1"></i>
                            User

                        </a>

                    </li>

                @endif


                {{-- PRODUK --}}
                <li class="nav-item">

                    <a href="{{ route('produk.index') }}"
                       class="nav-link
                       {{ Request::is('produk*') ? 'active' : '' }}">

                        <i class="bi bi-box-seam-fill me-1"></i>
                        Produk

                    </a>

                </li>


                {{-- PENJUALAN --}}
                <li class="nav-item">

                    <a href="{{ route('penjualan.index') }}"
                       class="nav-link
                       {{ Request::is('penjualan*') ? 'active' : '' }}">

                        <i class="bi bi-cart-check-fill me-1"></i>
                        Penjualan

                    </a>

                </li>



                {{-- =========================
                    JENIS PRODUK
                ========================== --}}
                @if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')

                    <li class="nav-item">

                        <a href="{{ route('jenis-produk.index') }}"
                           class="nav-link {{ Request::is('jenis-produk*') ? 'active' : '' }}">

                            <i class="bi bi-tags-fill me-1"></i>
                            Jenis Produk

                        </a>

                    </li>

                @endif


                {{-- TENTANG --}}
                @if(strtolower(optional(auth()->user()->role)->name) !== 'kasir')

                    <li class="nav-item">

                        <a href="{{ route('tentang') }}"
                           class="nav-link
                           {{ Request::is('tentang*') ? 'active' : '' }}">

                            <i class="bi bi-info-circle-fill me-1"></i>
                            Tentang

                        </a>

                    </li>

                @endif

            </ul>


            {{-- =========================
                BAGIAN KANAN
            ========================== --}}
            <div class="ms-auto d-flex align-items-center gap-3">

              
                {{-- LOGOUT --}}
                <form action="{{ route('logout') }}"
                      method="POST"
                      class="m-0">

                    @csrf

                    <button type="submit"
                            class="btn btn-logout">

                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>
</nav>


{{-- =========================
    STYLE NAVBAR
========================== --}}
<style>

    .navbar-custom {
        background: linear-gradient(
            90deg,
            #f783c8,
            #f58bcf,
            #ee7fc3
        );

        min-height: 70px;
        padding: 10px 0;

        position: sticky;
        top: 0;
        z-index: 1000;
    }


    /* LOGO */

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;

        color: white !important;

        font-size: 22px;
        font-weight: 700;

        text-decoration: none;
    }


    .logo-img {
        object-fit: contain;

        background: white;

        border-radius: 50%;

        padding: 3px;

        box-shadow:
            0 3px 10px rgba(0,0,0,.15);
    }


    /* MENU */

    .navbar-nav .nav-link {

        color: white !important;

        font-weight: 600;

        padding: 11px 15px;

        border-radius: 12px;

        transition: all .25s ease;
    }


    .navbar-nav .nav-link:hover {

        background: rgba(255,255,255,.22);

        transform: translateY(-1px);
    }


    /* MENU AKTIF */

    .navbar-nav .nav-link.active {

        background: white;

        color: #d63384 !important;

        box-shadow:
            0 4px 12px rgba(0,0,0,.10);
    }


    /* USER INFO */

    .user-info {

        background: rgba(255,255,255,.18);

        padding: 6px 12px;

        border-radius: 14px;

        color: white;
    }


    .user-icon {

        width: 34px;
        height: 34px;

        display: flex;

        align-items: center;
        justify-content: center;

        background: white;

        color: #d63384;

        border-radius: 50%;

        margin-right: 8px;
    }


    .user-text {

        display: flex;

        flex-direction: column;

        line-height: 1.1;
    }


    .user-text small {

        font-size: 10px;

        opacity: .9;
    }


    .user-text strong {

        font-size: 13px;
    }


    /* LOGOUT */

    .btn-logout {

        background: white;

        color: #d63384;

        border: none;

        padding: 10px 17px;

        border-radius: 12px;

        font-weight: 700;

        transition: all .25s ease;

        box-shadow:
            0 3px 10px rgba(0,0,0,.10);
    }


    .btn-logout:hover {

        background: #fff0f7;

        color: #b51f6b;

        transform: translateY(-2px);

        box-shadow:
            0 5px 15px rgba(0,0,0,.15);
    }


    /* MOBILE */

    .navbar-toggler {

        border: 2px solid rgba(255,255,255,.7);

        border-radius: 10px;

        padding: 7px 10px;
    }


    .navbar-toggler:focus {

        box-shadow: none;
    }


    .navbar-toggler-icon {

        filter: brightness(0) invert(1);
    }


    @media (max-width: 991px) {

        .navbar-collapse {

            background: rgba(255,255,255,.12);

            margin-top: 12px;

            padding: 12px;

            border-radius: 15px;
        }


        .navbar-nav {

            margin-left: 0 !important;
        }


        .navbar-nav .nav-link {

            margin-bottom: 4px;
        }


        .navbar-collapse .ms-auto {

            margin-top: 10px;

            margin-left: 0 !important;
        }

    }

</style>