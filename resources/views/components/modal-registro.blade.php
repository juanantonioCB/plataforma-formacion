<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="modalRegistro" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog modal-lg relative w-auto pointer-events-none">
    <div
      class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding  outline-none text-current">
      <div
        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel3">Regístrate</h5>
        <button type="button"
          class="btn-close  w-4 h-4 box-content text-p_p_gris_oscuro"
          data-bs-dismiss="modal" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="mr-5" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
      <form id="formRegistro">
        @csrf
        <div class="modal-body relative p-4">
            <div class="form-group mb-4">
                <label class="form-label inline-block mb-2 text-gris3 text-sm"
                  >Correo electrónico</label>
                <input
                  type="email"
                  class="form-control input"
                  id="email"
                  name="email"
                  placeholder="Introduzca su correo electrónico"
                />
            </div>
            <div class="grid grid-cols-12 gap-6 box">
              <div class="col-span-12 md:col-span-6">
                <div class="form-group mb-4">
                  <label class="form-label inline-block mb-2 text-gris3 text-sm"
                    >Nombre</label>
                  <input
                    type="text"
                    class="form-control input"
                    id="name_registro"
                    name="name_registro"
                    placeholder="Introduzca su nombre"
                  />
                </div>
              </div>
              <div class="col-span-12 md:col-span-6">
                <div class="form-group mb-4">
                  <label class="form-label inline-block mb-2 text-gris3 text-sm"
                    >Apellidos</label>
                  <input
                    type="text"
                    class="form-control input"
                    id="surname_registro"
                    name="surname_registro"
                    placeholder="Introduzca sus apellidos"
                  />
                </div>
              </div>
            </div>
            <div class="form-group mb-6 form-check mt-3">
                <input class="form-check-input appearance-none h-4 w-4  border border-gris  checked:bg-p_p_rojo checked:border-white focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer inline" type="checkbox" id="condiciones" name="condiciones">
                <label class="form-check-label text-p_p_gris_oscuro text-sm" for="condiciones">
                  Al registrarme acepto los <a href="{{ route('terminos') }}" class="text-p_s_marron " target="_blank">Términos de uso</a> y <a href="{{ route('politica') }}" class="text-p_s_marron " target="_blank">Políticas de Privacidad</a> de Incibe.
                </label>
            </div>
            <div>
                <div id="mensajeerror" class="mt-8 text-p_p_rojo text-sm">
                </div>
                <div id="mensajeok" class="mt-8 text-p_s_azul text-sm">
                </div>
            </div>

        </div>
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
            <a href="#" id="btnCerrar" class="button-modal-2" data-bs-dismiss="modal">Cerrar</a>
            <a href="#" id="btnCancelar" class="button-modal-2 hidden" data-bs-dismiss="modal">Cancelar</a>
            <button id="btnRegistrarme" type="button" class="button-modal-1 ml-5 enviarRegistro hidden" >
              Registrarme
              <svg id="loadingRegistro" width="18" height="18" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#fff" class="loading ml-3 -mt-1 inline">
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
