<div class="bg-p_s_marron text-white">
    <div class="container grid grid-cols-12 gap-4 py-5 md:pt-10 md:pb-10">
        <div class="col-span-12 lg:col-span-4 border-b lg:border-r lg:border-b-0 border-white pb-5 ">
            <div class="text-center text-lg font-bold ">
                PLAZO DE MATRICULACIÓN
            </div>
            <div class="flex flex-row mt-4 px-8 xl:px-16 2xl:px-32 justify-center lg:justify-start">
                <div class="w-6 xl:w-7 2xl:w-8 pt-0.5">
                    <img alt="" class="w-full" src="{{ asset('imgs/icono-calendar.png') }}" title="imagen">
                </div>
                <div class="ml-5 ">
                    @if ($estadoCurso == 'activo')
                        Del {{ Carbon\Carbon::parse($curso->edicionAbierta->init_date_mat)->translatedFormat('d \d\e F \d\e Y') }} al {{ Carbon\Carbon::parse($curso->edicionAbierta->end_date_mat)->translatedFormat('d \d\e F \d\e Y') }}
                    @else
                        No hay edición abierta actualmente
                    @endif
                </div>
            </div>
            
        </div>

        <div class="col-span-12 lg:col-span-4 border-b lg:border-r lg:border-b-0 border-white pb-5">
            <div class="text-center text-lg font-bold ">
                PERÍODO DEL CURSO
            </div>
            <div class="flex flex-row mt-4 px-8 xl:px-16 2xl:px-32 justify-center lg:justify-start">
                <div class="w-6 xl:w-7 2xl:w-8 pt-0.5">
                    <img alt="" class="w-full" src="{{ asset('imgs/icono-calendar.png') }}" title="imagen">
                </div>
                <div class="ml-5">
                    @if ($estadoCurso == 'activo')
                        Del {{ Carbon\Carbon::parse($curso->edicionAbierta->init_date)->translatedFormat('d \d\e F \d\e Y') }} al {{ Carbon\Carbon::parse($curso->edicionAbierta->end_date)->translatedFormat('d \d\e F \d\e Y') }}
                    @else
                        No hay edición abierta actualmente
                    @endif
                </div>
            </div>
            
        </div>

        <div class="col-span-12 lg:col-span-4 ">
            <div class="text-center text-lg font-bold ">
                TIEMPO ESTIMADO
            </div>
            <div class="flex flex-row mt-4 px-8 xl:px-16 2xl:px-32 justify-center lg:justify-start">
                <div class="w-6 xl:w-7 2xl:w-8 pt-0.5">
                    <img alt="" class="w-full" src="{{ asset('imgs/icono-reloj.png') }}" title="imagen">
                </div>
                <div class="ml-5">
                    {{ $curso->estimated_time }}
                </div>
            </div>
            
        </div>


    </div>
</div>


