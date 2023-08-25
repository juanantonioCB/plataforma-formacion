<ul class="nav nav-tabs tabs mt-10" id="tabs-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <a href="#tabs-categoria_1" class="nav-link active" id="tabs-categoria_1-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_1" role="tab" aria-controls="tabs-categoria_1"
      aria-selected="true">Explorar catálogo</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabs-categoria_2" class="nav-link" id="tabs-categoria_2-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_2" role="tab"
      aria-controls="tabs-categoria_2" aria-selected="false">En curso</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabs-categoria_3" class="nav-link" id="tabs-categoria_3-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_3" role="tab"
      aria-controls="tabs-categoria_3" aria-selected="false">Completados</a>
  </li>
  
</ul>
<div class="tab-content" id="tabs-tabContent">
  <div class="tab-pane fade show active" id="tabs-categoria_1" role="tabpanel" aria-labelledby="tabs-categoria_1-tab">
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-20">
          @foreach ($cursosTodos as $curso)
          <div>
             {{-- <x-card :curso="$curso" :subscriptorId="$subscriptorId"></x-card> --}}
             <x-card :curso="$curso" ></x-card>
          </div>
          @endforeach
      </div>
  </div>
  <div class="tab-pane fade" id="tabs-categoria_2" role="tabpanel" aria-labelledby="tabs-categoria_2-tab">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-20">
        @php  
          $cuenta = 0;
        @endphp
        @foreach ($cursosTodos as $curso)
          {{-- @if ($curso->cursosEnrolls->where('user_id', $subscriptorId)->count() == 1) --}}
          @if ($curso->cursosEnrolls->where('user_id', config('app.subscriptor_id'))->count() == 1)
          @php  
            $cuenta += 1;
          @endphp
          <div>
             {{-- <x-card :curso="$curso" :subscriptorId="$subscriptorId"></x-card> --}}
             <x-card :curso="$curso"></x-card>
          </div>
          @endif
        @endforeach
        @if ($cuenta == 0)
          No hay cursos en curso.
        @endif
    </div>
  </div>
  <div class="tab-pane fade" id="tabs-categoria_3" role="tabpanel" aria-labelledby="tabs-categoria_3-tab">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-20">
      @php  
        $cuenta = 0;
      @endphp
      @foreach ($cursosTodos as $curso)
        {{-- @if ($curso->cursosEnrollsFinished->where('user_id', $subscriptorId)->count() == 1) --}}
        @if ($curso->cursosEnrollsFinished->where('user_id', config('app.subscriptor_id'))->count() == 1)
        @php  
          $cuenta += 1;
        @endphp
        <div>
          <x-card :curso="$curso"></x-card>
        </div>
        @endif
      @endforeach
      @if ($cuenta == 0)
        No hay cursos finalizados.
      @endif
    </div>
  </div>
</div>
