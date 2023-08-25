<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="modalVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl relative w-auto  pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding  outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" >Vídeo</h5>
        <button type="button" id="cerrar"
          class="btn-close  w-4 h-4 box-content text-p_p_gris_oscuro"
          data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="mr-5" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>

      <div class="videoresponsive" style="position: relative;padding-bottom: 56.25%;height: 0;">
        <iframe src="{{ $video }}" id="video"  allowscriptaccess="always" allow="autoplay" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" allowfullscreen></iframe>
      </div>

    </div>
  </div>
</div>