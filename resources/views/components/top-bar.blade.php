<div class="top-bar hidden lg:block">
    <div class="flex ">
        {{-- <div class="flex-none w-10 border-r border-gris ">
        </div>
        <div class="flex-none w-14 py-1.5 pl-2.5 hidden xl:block">
            <a href="#">
                <span>SUSCRIPCIÓN BOLETINES</span>
            </a>
        </div> --}}
        <div class="grow text-right menu-superior {{-- xl:border-r xl:border-gris --}}pr-4 2xl:pr-10 text-sm">
            <ul>
                @if (!Auth()->user())
                    <li>
                        <a href="{{ route('keycloak.login') }}">Iniciar sesión</a>
                    </li>
                    <li>
                        <button type="text" class="botonRegistro" {{-- data-bs-toggle="modal" data-bs-target="#modalRegistro" --}}>
                            Regístrate
                        </button>
                        {{-- <button type="text"
                                class="botonRegistro"
                                data-te-toggle="modal"
                                data-te-target="#modalRegistro2"
                                data-te-ripple-init>
                            Regístrate
                        </button> --}}
                    </li>
                @else
                    <li>
                        {{ 'Bienvenido '.Auth()->user()->email }}
                    </li>
                    <li>
                        <a href="{{ route('salirOut') }}" class="logOutttt">Logout</a>  {{-- route('keycloak.logout') --}}
                    </li>
                @endif

            </ul>
        </div>
        <div class="flex-none {{-- w-0  xl:--}}w-1/6 ">
            <div class="float-right text-right w-20 py-1.5 pr-2.5 hidden xl:block ">
                <a href="#">
                    <span>PORTALES INCIBE</span>
                </a>
            </div>

        </div>
        <div class="flex-none w-10 border-l border-gris p-2">
            <img src="{{ asset('imgs/incibe-simbolo.svg') }}" alt="">
        </div>
      </div>
</div>


