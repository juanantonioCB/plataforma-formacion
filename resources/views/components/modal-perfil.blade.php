<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfil" aria-hidden="true">
  <div class="modal-dialog modal-xl relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding  outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800">EDITAR PERFIL</h5>
        <button type="button"
          class="btn-close  w-4 h-4 box-content text-p_p_gris_oscuro"
          data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="mr-5" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
      <form id="formPerfil" enctype="multipart/form-data">
        @csrf
        <div class="modal-body relative pl-4 pr-4 pt-4">
        
        </div>
        <div class="px-8">
            <div id="mensajeerror_perfil" class="mt-4 text-p_p_rojo text-sm">
            </div>
            <div id="mensajeok_perfil" class="mt-4 text-p_s_azul text-sm">
            </div>
        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
            <a href="#" id="btnCerrarPerfil" class="button-modal-2" data-bs-dismiss="modal">Cerrar</a>
            <button id="btnGuardarPerfil" type="button" class="button-modal-1 ml-5 guardarPerfil" >
              Guardar 
              <svg id="loadingPerfil" width="18" height="18" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#fff" class="loading ml-3 -mt-1 inline hidden">
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
        </div>

      </form>
    </div>
  </div>
</div>
