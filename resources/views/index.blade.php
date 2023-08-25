@extends('../layouts/mainfront')


@section('content')
    
    <x-menu-mobile/>

    <x-top-bar/>

    <x-barra-logo :avatar="$avatar"/>

    @if (Auth()->user())
        <x-cabecera-auth/>
    @endif

    <div class="container">
        
        @if (!Auth()->user())
            <x-slider :contenido="$contenido"/>

            <div class="titulo ">
                COMIENZA A APRENDER DE LOS MEJORES EN CIBERSEGURIDAD
            </div>
    
            <x-tabs :cursosDisponibles="$cursosDisponibles" :cursosTodos="$cursosTodos"/>
        @endif

        @if (Auth()->user())
            <x-tabs-auth :cursosDisponibles="$cursosDisponibles" :cursosTodos="$cursosTodos" {{-- :subscriptorId="$subscriptor_id" --}}/>
        @endif
        <div class="h-24 md:h-44"></div>

    </div>

    <x-pie/>

    <x-modal-registro/>

    <x-modal-perfil/>

    {{-- @include('layouts.modals.modalperfil') --}}
    

@endsection