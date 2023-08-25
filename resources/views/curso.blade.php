@extends('../layouts/mainfront')


@section('content')
    
    <x-menu-mobile/>

    <x-top-bar/>

    <x-barra-logo :avatar="$avatar"/>

    <x-curso.volver/>
    
    <div class="container">
        <x-curso.cabecera :curso="$curso" :estado="$estado" :estadoCurso="$estado_curso" :terminado="$terminado" :enroll2="$enroll2"/>
    </div>

    <x-curso.banda :curso="$curso" :estadoCurso="$estado_curso"/>

    <div class="container">
        <x-curso.descripcion :curso="$curso"/>
    </div>

    <x-pie/>

    <x-modal-registro/>

    <x-modal-perfil/>
    
    {{-- <x-curso.modal-video :video="$curso->video_url"/> --}}


@endsection

