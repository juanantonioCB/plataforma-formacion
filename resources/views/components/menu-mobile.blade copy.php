<div class="flex lg:hidden">
    
    <nav class="relative flex flex-wrap items-center justify-between pb-2 pt-1 navbar navbar-expand-xl navbar-light">
        <div class="container-fluid w-full flex flex-wrap items-center justify-between ">
            <button class="navbar-toggler text-p_p_rojo border-0 hover:shadow-none hover:no-underline  bg-transparent focus:outline-none focus:ring-0 focus:shadow-none focus:no-underline pl-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-9" role="img"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
            </button>
            <div class="collapse navbar-collapse flex-grow items-center bg-gris3 text-white pl-3 py-4" id="navbarSupportedContent">
                
                <!-- Left links -->
                <ul class="navbar-nav flex flex-col pl-0 list-style-none mr-auto">
                    @if (!Auth()->user())
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0" href="{{ route('keycloak.login') }}">Iniciar sesión</a>
                        </li>
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0 botonRegistro" href="#" data-bs-toggle="modal" data-bs-target="#modalRegistro">Regístrate</a>
                        </li>
                        <li class="divider pr-2 pt-3 pb-2">
                            <hr>
                        </li>
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0" href="#">Conoce nuestros cursos</a>
                        </li>
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0" href="#">Conoce INCIBE</a>
                        </li>
                    @else 
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0" href="{{ route('keycloak.logout') }}">Cerrar sesión</a>
                        </li>
                        <li class="nav-item p-2">
                            <a class="nav-link text-white p-0" href="#">Editar Perfil</a>
                        </li>
                        
                    @endif
                    
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
            

            <!-- Right elements -->
            {{-- <div class="flex items-center relative"> --}}
            <!-- Icon -->
            
            {{-- </div> --}}
        <!-- Right elements -->
        </div>

        
    </nav>

    <div class="grid place-content-center place-self-start grow pt-2">
        <img src="{{ asset('imgs/logo_mobile.png') }}" alt="" class="max-h-8 ">
    </div>

</div>
