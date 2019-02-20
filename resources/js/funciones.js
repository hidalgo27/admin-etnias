

function mostrar_provincias(departamento_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+departamento_id);
    if(departamento_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-provincias',
        data:{departamento_id:departamento_id},
        success:function(data){
            $("select[name='provincia'").html('');
            $("select[name='provincia'").html(data.options);
        }
        });
    }
}
function mostrar_distritos(provincia_id){
    // alert('hola:'+departamento_id);
    console.log('departamento_id:'+provincia_id);
    if(provincia_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-distritos',
        data:{provincia_id:provincia_id},
        success:function(data){
            $("select[name='distrito'").html('');
            $("select[name='distrito'").html(data.options);
        }
        });
    }
}
function mostrar_comunidades(distrito_id,asociacion_id){
    // alert('hola:'+departamento_id);
    console.log('distrito_id:'+distrito_id);
    if(distrito_id>0){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
        type:'POST',
        url:'mostrar-comunidades',
        data:{distrito_id:distrito_id},
        success:function(data){

            $("#comunidad_"+asociacion_id).html('');
            $("#comunidad_"+asociacion_id).html(data.options);
        }
        });
    }
}

function borrar_foto_cliente(id){
    // alert('hola:'+departamento_id);
    $("#"+id).remove();

}

function borrar_foto_asociacion(id){
    // alert('hola:'+departamento_id);
    $("#"+id).remove();

}

function eliminar(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar la comunidad?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/comunidad/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'La comunidad ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_comunidades_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Subo un error al borrar la comunidad.',
                            'danger'
                        )
                    }
                }
             });
        }
      })

}
function eliminar_asociacion(id){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar la asociacion?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText:'No, cancelar'
      }).then((result) => {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url:'/admin/asociacion/delete/'+id,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'La asociacion ha sido borrada.',
                            'success'
                        );
                        $('#row_lista_asociaciones_'+id).remove();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Subo un error al borrar la asociacion.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}

function buscar_asociacion(ruc_rs){
    var valor=$.trim(ruc_rs);
    if(valor.length>0){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'get',
            url:'/admin/servicios/buscar/'+valor,
            // data:{id:id},
            success:function(data){
                $('#asociacion').html('');
                $('#asociacion').html(data);
            }
         });
    }
}
var nro_hijos_actividad=1;
function agregar_precio_actividad(){
    nro_hijos_actividad++;
    var cadena='<tr id="row_actividad_precios_'+nro_hijos_actividad+'">'+
    '<td>'+
    '<select class="form-control" name="categoria[]" id="categoria">'+
        '<option value="Nacional">Nacional</option>'+
        '<option value="Extranjero">Extranjero</option>'+
        '<option value="Agencia">Agencia</option>'+
    '</select>'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="minimo[]" id="minimo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="maximo[]" id="maximo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="precio[]" id="precio">'+
    '</td>'+
    '<td>'+
        '<button class="btn btn-danger" type="button" onclick="borrar_precio_actividad('+nro_hijos_actividad+')"><i class="fas fa-trash-alt"></i></button>'+
        '<button class="btn btn-success d-none" type="button" onclick="agregar_precio_actividad()"><i class="fas fa-plus"></i></button>'+
    '</td>'+
'</tr>';
    $('#actividad_precios').append(cadena);
}
function borrar_precio_actividad(pos){
    $('#row_actividad_precios_'+pos).remove();

}
// function guardar_actividad(){
//     $.ajaxSetup({
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         type:'post',
//         url: $("#form_actividad").attr('action'),
//         method: $("#form_actividad").attr('method'),
//         data: $("#form_actividad").serialize(),
//         // dataType:'json',
//         // async:false,
//         processData: false,
//         contentType: false,
//         success:function(data){
//             alert('rpta:'+data);
//         }
//         });
// }
function enviar_datos(){
    if($('#actividad_asociacion_id').val()==''){
        $('#ruc_rs').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese un numero de ruc, razon social o nombre',
          })
        return false;
    }
    if($('#titulo').val().trim()==''){
        $('#titulo').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese el titulo',
          })
        return false;
    }
    if($('#descripcion').val().trim()==''){
        $('#descripcion').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese una descripcion',
          })
        return false;
    }
    // $("input[name='foto[]']").each(function(indice, elemento) {
    //     if($(elemento).val()==''){
    //         $(elemento).focus();
    //         Swal.fire(
    //             'Good job!',
    //             'You clicked the button!',
    //             'success'
    //           )
    //         return false;
    //     }
    // });
    var minimo=0;
    $("input[name='minimo[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            minimo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var maximo=0;
    $("input[name='maximo[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            maximo++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    var precio=0;
    $("input[name='precio[]']").each(function(indice, elemento) {
        if(!$.isNumeric($(elemento).val())){
            precio++;
            $(elemento).focus();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Ingrese un valor numerico',
            })
            return false;
        }
    });
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: $("#form_actividad").attr('action'),
        method: $("#form_actividad").attr('method'),
        data:new FormData($("#form_actividad")[0]),
        dataType:'json',
        contentType:false,
        cache:false,
        processData: false,
        beforeSend: function() {
            $('#rpt_form_actividad').html('');
            $('#rpt_form_actividad').html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
        },
        success:function(data){
            $('#rpt_form_actividad').html(data.mensaje);
            $('#rpt_form_actividad').addClass(data.nombre_clase);
            $("#form_actividad")[0].reset();
        }
        });
}
