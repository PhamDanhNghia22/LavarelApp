<header class='shadow'>
    <div class='bg-dark text-center py-2'>
        <span class='text-white'>Your fashion partner</span>
    </div>
    <div class='container'>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" width="170" alt="" srcset="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Women</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Kids</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mens</a>
                        </li>

                    </ul>
                    <div class='nav-right d-flex align-items-center'>
                        
                        @if(Auth::check())
                            <span class='ms-3 fs-5 text-dark '>
                                {{ Auth::user()->name }}
                            </span>
                            <a href="{{ route('auth.logout') }}" class='ms-3 fs-5 text-dark '>Đăng xuất</a>
                        @else
                            <a href="/login" class='ms-3 fs-4 text-dark '>
                                <i class="bi bi-person"></i>
                            </a>
                        @endif



                        <a href="/cart" class='ms-3 fs-4 text-dark '>
                            <i class="bi bi-bag"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

</header>