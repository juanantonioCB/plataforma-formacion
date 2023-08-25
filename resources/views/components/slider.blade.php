<div class="grid grid-cols-12 gap-4 pt-20 mb-24">
    <div class="col-span-12 lg:col-span-5 order-2 lg:order-1 flex items-stretch">
        <div class="px-8 lg:px-0 lg:self-end">
            <div class="mt-5 lg:mt-0">
                <span class="text-p_p_rojo font-bold text-4xl xl:text-5xl lg:leading-12">{{ $contenido->title }}</span>
            </div>
            <div class="mt-6 xl:mt-12 text-gris3">
                <span class=" text-gris2 leading-6 xl:leading-8 text-lg xl:text-xl">{{ $contenido->short_desc }}</span>
            </div>
            <div class="mt-6 xl:mt-10">
                <a href="{{ $contenido->link_button }}" class="button-slider">{{ $contenido->text_button }}</a>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-7 order-1 lg:order-2 pl-12 pr-12 lg:pr-0 lg:pl-28 xl:pl-48">
        <img alt="" class="class="w-full" src="{{ $contenido->imagen }}" title="imagen">
        {{-- <img src="{{ asset('imgs/imagen_slider.png') }}" alt="" class="w-full"> --}}
    </div>
</div>

