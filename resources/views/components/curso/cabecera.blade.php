<div class="grid grid-cols-12 gap-4 pt-10 mb-24">
    <div class="col-span-12 lg:col-span-5 order-2 lg:order-1 flex items-stretch">
        <div class="px-5 md:px-14 lg:px-0 lg:self-end">
            <div class="mt-5 lg:mt-0">
                <span class="text-p_p_rojo font-bold text-3xl md:text-4xl xl:text-5xl xl:leading-12">{{ $curso->name }}</span>
            </div>
            <div class="mt-6 xl:mt-12 text-gris3">
                <span class=" text-gris2 leading-6 xl:leading-8 text-lg xl:text-xl">{{ $curso->short_desc }}</span>
            </div>
            <div class="mt-6 xl:mt-10">
                @if (!Auth()->user())
                    <a href="#" class="button-slider botonRegistro" data-bs-toggle="modal" data-bs-target="#modalRegistro">Regístrate ahora</a>
                @endif
                @if (Auth()->user())
                    @if ($estado == 'no enroll' && $estadoCurso == 'activo' && $terminado =='no')
                    <button class="button-inscribete inscripcionCurso" data-item_id="{{ $curso->id }}">
                        Inscríbete
                        <svg id="loadingInscripcion" width="18" height="18" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#fff" class="loading ml-3 -mt-1 inline hidden">
                            <g fill="none" fill-rule="evenodd">
                                <g transform="translate(1 1)" stroke-width="2">
                                    <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                        <animateTransform
                                            attributeName="transform"
                                            type="rotate"
                                            from="0 18 18"
                                            to="360 18 18"
                                            dur="1s"
                                            repeatCount="indefinite"/>
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </button>
                    @endif
                    @if ($terminado == 'si')
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6 mt-5">
                                <a href="#" target="_blank" class="button-terminado" >Terminado</a>
                            </div>
                            <div class="col-span-6">
                                @if ($enroll2->url_evidence)
                                <div class="">
                                    <a href="{{ $enroll2->url_evidence }}" target="_blank">
                                        <img src="{{ $enroll2->edicion->badge_img_url }}" class="h-20" alt="">
                                    </a>
                                </div>
                            @endif
                            </div>
                        </div>
                    @endif
                    @if ($estado == 'enroll')
                        {{-- <a href="{{ config('app.moodle_course').'/view.php?id='.$curso->course_id.'&saml=on' }}" target="_blank" class="button-iralcurso" >Ir al curso</a> --}}
                        <button class="button-iralcurso irAlCurso" data-item_id="{{ config('app.moodle_course').'/view.php?id='.$curso->course_id.'&saml=on' }}">
                            Ir al curso
                        </button>
                        <button class="button-iralforo irAlForo" data-item_id="{{ config('app.foro_base_url').'/'.$curso->edicionAbierta->id.'/'.$curso->id }}">
                            Ir al foro
                        </button>
                        {{-- <a href="{{ config('app.foro_base_url').'/'.$curso->edicionAbierta->id.'/'.$curso->id }}" target="_blank" class="button-iralforo" >Ir al foro</a> --}}
                        {{-- <button class="button-iralcurso bg-p_s_marron mt-8 obtenerMedalla" data-item_id="{{ $curso->id }}">
                            Obtener medalla
                        </button> --}}
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-7 order-1 lg:order-2 px-5 md:pl-12 md:pr-12 lg:pr-0 lg:pl-28 xl:pl-48 ">
        <div class="relative flex items-stretch justify-center">
            @if (!empty($curso->imagen))
                <img alt="" class="w-full" src="{{ $curso->imagen }}" title="imagen">
            @else
                <img alt="" class="rounded-t object-cover w-full" src="{{ asset('imgs/preview2.jpg') }}" title="imagen">
            @endif
            {{-- <img alt="" class="class="w-full" src="{{ config('app.app_url_admin').'/storage/imgs/coursers/'.$curso->image }}" title="imagen"> --}}
            @if ($curso->video_url !== null && $curso->video_url !== '')
                <div class="absolute self-center ">
                    <a href="{{ $curso->video_url }}" target="_blank" aria-label="{{ $curso->video_url }}">
                        <img alt="" class="w-3/4 sm:w-full lg:w-3/4 xl:w-full" src="{{ asset('imgs/play.png') }}" title="imagen">
                    </a>
                </div>
            @endif
        </div>

    </div>

</div>

