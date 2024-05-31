<nav class="navbar  navbar-expand-lg navbar-dark" style="background-color: #000428;">
    <div class="container">
        <a class="navbar-brand" href="/">  
        <img class=" img-responsive" name="brand_image"
                                src="{{asset('images/assets/eat2bfit_logo.svg')}}"  alt="brand-image"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="prijava" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="prijava">
                        @if (Route::has('login'))
                        @auth
                        <a class="dropdown-item" href="{{ url('/home') }}">Moj profil</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odjava</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @else
                        <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                        <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                        @endif
                        @endauth
                        @endif
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>