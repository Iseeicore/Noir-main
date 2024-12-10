<!-- resources/views/modulos/layouts/aside.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link d-flex align-items-center">
        <img src="" id="logo_sistema" alt="Logo Empresa" class="brand-image img-circle elevation-3 me-2" style="width: 35px; height: 35px; opacity: .8;">
        <span id="nombre_comercial" class="brand-text font-weight-light text-truncate" style="max-width: 150px;">Nombre Empresa</span>
    </a>
    

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <h6 class="text-warning">
                    {{ strlen(Auth::user()->usuario) > 10 ? 'Hola, ' . substr(Auth::user()->usuario, 0, 10) . '...' : 'Hola, ' . Auth::user()->usuario }}
                </h6>
            </div>
        </div>

    

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($menuUsuario as $menu)
                    <li class="nav-item {{ $menu->abrir_arbol ? 'menu-is-opening menu-open' : '' }}">
                        <a style="cursor: pointer;" class="nav-link {{ $menu->vista_inicio ? 'active' : '' }}"
                            @if ($menu->vista) onclick="cargarPlantilla('{{ $menu->vista }}', 'content-wrapper')" @endif>
                            <i class="nav-icon {{ $menu->icon_menu }}"></i>
                            <p>
                                {{ $menu->modulo }}
                                @if (!$menu->vista)
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>

                        @if (!$menu->vista)
                            <ul class="nav nav-treeview">
                                @foreach (app('App\Http\Controllers\SeguridadController')->obtenerSubMenu($menu->id) as $subMenu)
                                    <li class="nav-item">
                                        <a style="cursor: pointer;"
                                            class="nav-link {{ $subMenu->vista_inicio ? 'active' : '' }}"
                                            onclick="cargarPlantilla('{{ $subMenu->vista }}', 'content-wrapper')">
                                            <i class="{{ $subMenu->icon_menu }} nav-icon"></i>
                                            <p>{{ $subMenu->modulo }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                <li class="nav-item">
                    <a style="cursor: pointer;" class="nav-link" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
