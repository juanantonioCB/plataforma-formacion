
    <div class=" h-16 hidden lg:flex">
        <div class="flex w-2/5">
            <div class="w-1/3 bg-p_p_rojo">

            </div>
            <div class="w-2/3 px-8 grid place-content-center">
                <a href="{{ route('index') }}" aria-label="Ir a inicio">
                    <img src="{{ asset('imgs/incibe_logo_es.svg') }}" alt="" class="max-h-16 w-full">
                </a>
            </div>
        </div>
        <div class="w-3/5">
            <div class="flex">
                <div class="flex-none bg-p_p_gris_oscuro text-white text-right pr-4 w-2/3 h-16 menu ">
                    <ul>
                        @if (!Auth()->user())
                            {{-- <li>
                                <a href="#">Conoce nuestros cursos</a>
                            </li>
                            <li>
                                <a href="#">Conoce INCIBE</a>
                            </li> --}}
                        @else 
                            {{-- <li>
                                <button type="text" class="cerrarSesion">
                                    Cerrar sesión
                                </button>
                            </li> --}}
                            <li>
                                <button type="text" class="modalPerfil" {{-- data-bs-toggle="modal" data-bs-target="#modalPerfil" --}}>
                                    <div class="flex">
                                        @if ($avatar)
                                            <img alt="" class="rounded-full h-8 -mt-1" src="{{ $avatar  }}">
                                        @else
                                            <img alt="" class="rounded-full h-8 -mt-1" src="{{ asset('imgs/perfil.png') }}">
                                        @endif
                                        <span class="ml-3">Editar Perfil</span> 
                                    </div>
                                </button>
                            </li>
                        @endif
                    </ul>

                </div>
                {{-- <div class="flex-none w-16 text-p_p_rojo grid place-content-center text-2xl">
                    <button class="button-barra" id="btnSearch" aria-label="btnSearch">
                        <i class="fas fa-search"></i>
                    </button>
                </div> --}}
                <div class="grow bg-p_p_amarillo text-gris3 text-right pr-2 h-16 pt-2">
                    
                </div>
            </div>
        </div>
    </div>


