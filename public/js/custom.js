(function ($) {
    "use strict";

    $('.enviarRegistro').on('click',function(){
        $('#mensajeok').html('');
        $('#mensajeerror').html('');
        $(".loading").removeClass("hidden");
        const form_data = $('#formRegistro').serialize();
        $.ajax({
            type:'POST', url:'/enviarRegistro',
            data: form_data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if (response.status == "error") {
                    $('#mensajeok').html('');
                    $('#mensajeerror').html(response.errores);
                    $(".loading").addClass("hidden");
                    /* $(".preloader2").delay(300).fadeOut(0); */
                }
                if (response.status == "ok") {
                    $('#mensajeok').html(response.resp);
                    $("#btnCancelar").addClass("hidden");
                    $("#btnRegistrarme").addClass("hidden");
                    $("#btnCerrar").removeClass("hidden");
                    $(".loading").addClass("hidden");
                    /*$(".preloader2").delay(300).fadeOut(0); */
                }

            }
        });

    });

    $('.botonRegistro').on('click',function(){
        $('#email').val('');
        $('#name').val('');
        $('#surname').val('');
        $("#condiciones").prop("checked", false);
        $('#mensajeok').html('');
        $('#mensajeerror').html('');
        $("#btnCerrar").addClass("hidden");
        $("#btnCancelar").removeClass("hidden");
        $("#btnRegistrarme").removeClass("hidden");
        $(".loading").addClass("hidden");
        $('#modalRegistro').modal('show');
    });

    $('.inscripcionCurso').on('click',function(){
        var idCurso;
        idCurso = $(this).data('item_id');
        $(".loading").removeClass("hidden");
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:'/inscripcionCurso',
            data:"idCurso=" + idCurso,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if (response.status == "error") {
                    //alert(response.errores);
                    Swal.fire(
                        '',
                        response.errores,
                        'error'
                    );
                    $(".loading").addClass("hidden");

                }
                if (response.status == "ok") {
                    Swal.fire(
                        '',
                        response.resp,
                        'success'
                    );
                    $(".loading").addClass("hidden");
                    window.location.reload();
                }
            },
            error:function(error) {
                Swal.fire(
                    '',
                    'Sesión caducada',
                    'error'
                );
                window.location.reload();
            }
        });
    });

    $('.modalPerfil').on('click',function(){
        $.ajax({
            type:'GET', url:'/perfil',
            success:function(html){
                if (html=='') {
                    Swal.fire(
                        '',
                        'Sesión caducada',
                        'error'
                    );
                    window.location.reload();
                } else {
                    $('#mensajeok_perfil').html('');
                    $('#mensajeerror_perfil').html('');
                    $('#modalPerfil .modal-body').html(html);
                    $('#modalPerfil').modal('show');
                }
            }
        });
    });

    $('#btnGuardarPerfil').on('click',function(){
        $(".loading").removeClass("hidden");
        $('#mensajeok_perfil').html('');
        $('#mensajeerror_perfil').html('');
        var fileInput = document.getElementById('picture');
        var formData = new FormData();
        formData.set('email', document.getElementById('email').value);
        formData.set('nick', document.getElementById('nick').value);
        formData.set('name', document.getElementById('name').value);
        formData.set('surname', document.getElementById('surname').value);
        formData.set('birth_date', document.getElementById('birth_date').value);
        if (fileInput.value != '') {
            formData.set('picture', fileInput.files[0]);
        }
        $.ajax({
            type:'POST', url:'/guardarPerfil',
            data: formData, cache: false, contentType : false, processData : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if (response.status == "error") {
                    $('#mensajeok_perfil').html('');
                    $('#mensajeerror_perfil').html(response.errores);
                    $(".loading").addClass("hidden");
                }
                if (response.status == "ok") {
                    Swal.fire(
                        '',
                        response.resp,
                        'success'
                    );
                    $('#mensajeok_perfil').html(response.resp);
                    $(".loading").addClass("hidden");
                    window.location.reload();
                }

            }
        });
    });




    $('.cerrarSesion').on('click',function(){
        $.ajax({
            type:'POST', url:'/cerrarSesion',
            cache: false, contentType : false, processData : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){

            }
        });
    });

    $('.obtenerMedalla').on('click',function(){
        var idCurso;
        idCurso = $(this).data('item_id');
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:'/obtenerMedalla',
            data:"idCurso=" + idCurso,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if (response.status == "error") {
                    //alert(response.errores);
                    Swal.fire(
                        '',
                        response.errores,
                        'error'
                    );
                }
                if (response.status == "ok") {
                    Swal.fire(
                        '',
                        response.resp,
                        'success'
                    );
                    window.location.reload();
                }
            }
        });
    });


    $('.irAlCurso').on('click',function(){
        var enlace;
        enlace = $(this).data('item_id');
        $.ajax({
            type:'GET',
            dataType: 'json',
            url:'/irAlCurso',
            data:"enlace=" + enlace,
            success:function(response){
                if (response.status == "error") {
                    Swal.fire(
                        '',
                        'Sesión caducada',
                        'error'
                    );
                    window.location.reload();
                }
                if (response.status == "ok") {

                    window.open(response.enlace,'_blank');
                }
            }
        });
    });

    $('.irAlForo').on('click',function(){
        var enlace;
        enlace = $(this).data('item_id');
        $.ajax({
            type:'GET',
            dataType: 'json',
            url:'/irAlForo',
            data:"enlace=" + enlace,
            success:function(response){
                if (response.status == "error") {
                    Swal.fire(
                        '',
                        'Sesión caducada',
                        'error'
                    );
                    window.location.reload();
                }
                if (response.status == "ok") {

                    window.open(response.enlace,'_blank');
                }
            }
        });
    });



})(window.jQuery);
