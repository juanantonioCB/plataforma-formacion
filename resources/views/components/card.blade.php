<div class="flex ">
    <div class=" rounded shadow-lg bg-white w-full">
      <a href="{{ route('curso',['uuid' => $curso->id ]) }}" aria-label="linkCard" class="h-52">
        {{-- <img class="rounded-t" src="{{ asset('imgs/card.jpg') }}" alt=""/> --}}
        @if (!empty($curso->imagen))
            <img alt="" class="rounded-t object-cover w-full " src="{{ $curso->imagen }}" title="imagen">
        @else
            <img alt="" class="rounded-t object-cover w-full" src="{{ asset('imgs/preview2.jpg') }}" title="imagen">
        @endif
      </a>
      <div class="p-3 md:p-6">
          <a aria-label="enlace1-{{ $curso->id }}" href="{{ route('curso',['uuid' => $curso->id ]) }}" >
            <h5 class=" text-p_p_rojo text-2xl font-bold my-2 mr-10">{{ $curso->name }}</h5>
            <p class="text-gris3 text-xl mb-8 mt-4">
              {{ $curso->short_desc }}
            </p>
          </a>
          @if (Auth()->user())
            @if ($curso->cursosEnrolls->where('user_id', config('app.subscriptor_id'))->where('discontinued',false)->count() == 1)
              <button type="button" class="button-tag-encurso" id="tag" aria-label="card">EN CURSO</button>
            @endif
            @if ($curso->cursosEnrollsFinished->where('user_id', config('app.subscriptor_id'))->count() == 1)
              <button type="button" class="button-tag-terminado" id="tag" aria-label="card">TERMINADO</button>
            @endif
          @endif
      </div>
      <div class="py-4 px-6 border-t-2 border-gris text-gris3 flex flex-row items-center">
        <div class="basis-5/6 font-bold text-lg ">
            <a aria-label="enlace2-{{ $curso->id }}" href="{{ route('curso',['uuid' => $curso->id ]) }}" >
              DESCUBRE MÁS
            </a>
        </div>
        <div class="basis-1/6 text-p_s_marron text-5xl grid place-content-center">
            <a aria-label="enlace3-{{ $curso->id }}" href="{{ route('curso',['uuid' => $curso->id ]) }}" >
              <i class="fas fa-plus-circle"></i>
            </a>
        </div>        
      </div>
    </div>
</div>