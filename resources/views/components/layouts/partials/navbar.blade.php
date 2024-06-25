<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon fas fa-solid fa-store"></i> Home</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block mr-2">
            <a href="{{ route('sales.create') }}" class="nav-link btn btn-sm bg-purple"><i
                    class="nav-icon fas fa-cart-plus"></i> Criar
                Venda</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('sales.list') }}" class="nav-link btn btn-sm btn-primary"><i
                    class="nav-icon fas fa-cart-plus"></i> Listar
                Venda</a>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            @livewire('search')
        </li>



        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->imagem }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">

                <li class="user-header bg-lightblue">
                    <img src="{{ auth()->user()->imagem }}" class="img-circle elevation-2" alt="User Image">

                    <p>
                        {{ auth()->user()->name }}
                        <small>{{ auth()->user()->admin ? 'Administrador' : 'Usuário' }}</small>
                    </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('users.show', auth()->user()) }}" class="btn btn-default btn-flat">Perfil</a>
                    <a class="btn btn-default btn-flat float-right" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                        Salir
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
