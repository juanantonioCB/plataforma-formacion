<ul class="nav nav-tabs tabs px-5 md:px-0 " id="tabs-tab" role="tablist">
  <li class="nav-item " role="presentation">
    <a href="#tabs-categoria_1" class="nav-link active" id="tabs-categoria_1-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_1" role="tab" aria-controls="tabs-categoria_1"
      aria-selected="true">Disponibles</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabs-categoria_2" class="nav-link" id="tabs-categoria_2-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_2" role="tab"
      aria-controls="tabs-categoria_2" aria-selected="false">Todos</a>
  </li>
  {{-- <li class="nav-item" role="presentation">
    <a href="#tabs-categoria_3" class="nav-link" id="tabs-categoria_3-tab" data-bs-toggle="pill" data-bs-target="#tabs-categoria_3" role="tab"
      aria-controls="tabs-categoria_3" aria-selected="false">Categoria 3</a>
  </li> --}}
  
</ul>
<div class="tab-content px-5 md:px-0" id="tabs-tabContent">
  <div class="tab-pane fade show active" id="tabs-categoria_1" role="tabpanel" aria-labelledby="tabs-categoria_1-tab">
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-20">
          @foreach ($cursosDisponibles as $curso)
          <div>
            <x-card :curso="$curso"></x-card>
            {{-- @include('components.card') --}}
          </div>
          @endforeach
      </div>
  </div>
  <div class="tab-pane fade" id="tabs-categoria_2" role="tabpanel" aria-labelledby="tabs-categoria_2-tab">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-20">
        @foreach ($cursosTodos as $curso)
          <div>
            <x-card :curso="$curso"></x-card>
            {{-- @include('components.card') --}}
          </div>
        @endforeach
    </div>
  </div>
</div>
  {{-- <div class="tab-pane fade" id="tabs-categoria_3" role="tabpanel" aria-labelledby="tabs-categoria_3-tab">
    <div class="grid grid-cols-3 gap-20">
      <div>
        <x-card></x-card>
      </div>
      <div>
        <x-card></x-card>
      </div>
      <div>
        <x-card></x-card>
      </div>
    </div>
  </div>
</div> --}}