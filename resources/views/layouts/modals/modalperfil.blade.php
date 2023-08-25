<div class="grid grid-cols-12 gap-6 box p-5">
    <div class="col-span-12 flex justify-center">
        @if ($avatar)
            <img alt="" class="rounded-full h-14" src="{{ $avatar }}">
        @else
            <img alt="" class="rounded-full h-14" src="{{ asset('imgs/perfil.png') }}">
        @endif
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 form-group">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Email</label>
            <input id="email" name="email" type="text" class="form-control input w-full" style="background-color: #bbbbbb !important" value="{{ $subscriptor->email }}" readonly>
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 form-group">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Nick</label>
            <input id="nick" name="nick" type="text" class="form-control input w-full" placeholder="Nick..." value="{{ $subscriptor->nick }}" maxlength="255">
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 form-group">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Nombre</label>
            <input id="name" name="name" type="text" class="form-control input w-full" placeholder="Nombre..." value="{{ $subscriptor->name }}" maxlength="255">
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 form-group">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Apellido/s</label>
            <input id="surname" name="surname" type="text" class="form-control input w-full" placeholder="Apellido/s..." value="{{ $subscriptor->surname }}" maxlength="255">
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 form-group">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Fecha de nacimiento</label>
            <x-date id="birth_date" name="birth_date" class="form-control input w-full" value="{{ $subscriptor->birth_date }}"/>
        </div>
    </div>
    <div class="col-span-12 md:col-span-6">
        <div class="mt-1 w-full">
            <label class="form-label inline-block mb-2 text-gris3 text-sm">Imagen de perfil</label>
            <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
            rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="picture" name="picture">
        </div>
        <div class="mt-1 w-full text-xs text-p_s_azul">
            Características idóneas para la imagen de perfil:<br/>
            Formato cuadrado, máximo de anchura 800 px, tipo jpg o png optimizado en tamaño para no exceder de 300 Kbytes.
        </div>
    </div>
 </div>
