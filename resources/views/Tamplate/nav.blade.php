<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/logo-ifood.png') }}" alt="Bootstrap" width="170px;" height="100px;" style="margin-top: 5px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse  justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="#">Meu Perfil</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Lista de Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            Sair
                        </a>
                        <form id="frm-logout" action="{{ route('post.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('get.cadastro') }}">Cadastre-se</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('get.login') }}">Login</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
