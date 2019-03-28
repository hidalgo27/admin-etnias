

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
            url:'/admin/asociacion/buscar/'+valor,
            // data:{id:id},
            success:function(data){
                $('#asociacion').html('');
                $('#asociacion').html(data);
            }
         });
    }
}
// var nro_hijos_acti=1;
// var nro_hijos_comi=1;
// var nro_hijos_hosp=1;
// var nro_hijos_tran=1;
// var nro_hijos_serv=1;
function agregar_precio(valor1,valor2){

    var valor=$('#cantidad_precios_'+valor1+'_'+valor2).val();
    valor++
    $('#cantidad_precios_'+valor1+'_'+valor2).val(valor);
    var cadena='<tr id="row_'+valor1+'_precios_'+valor2+'_'+valor+'">'+
    '<td>'+
    '<select class="form-control" name="categoria_n[]" id="categoria">'+
        '<option value="Nacional">Nacional</option>'+
        '<option value="Extranjero">Extranjero</option>'+
        '<option value="Agencia">Agencia</option>'+
    '</select>'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="minimo_'+valor1+'_n_'+valor2+'[]" id="minimo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="maximo_'+valor1+'_n_'+valor2+'[]" id="maximo">'+
    '</td>'+
    '<td>'+
        '<input class="form-control" type="number" min="0" name="precio_'+valor1+'_n_'+valor2+'[]" id="precio">'+
    '</td>'+
    '<td>'+
        '<button class="btn btn-danger" type="button" onclick="borrar_precio(\''+valor1+'\',\''+valor2+'\',\''+valor+'\')"><i class="fas fa-trash-alt"></i></button>'+
        '<button class="btn btn-success d-none" type="button" onclick="agregar_precio(\''+valor1+'\')"><i class="fas fa-plus"></i></button>'+
    '</td>'+
'</tr>';
    $('#'+valor1+'_precios_'+valor2).append(cadena);
}
function borrar_precio(valor1,valor2,valor3){
    $('#row_'+valor1+'_precios_'+valor2+'_'+valor3).remove();

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
function enviar_datos(valor1,valor2){
    if($('#'+valor1+'_asociacion_id').val()==''){
        $('#ruc_rs').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese un numero de ruc, razon social o nombre',
          })
        return false;
    }
    if($('#titulo_'+valor1+'_'+valor2).val().trim()==''){
        $('#titulo_'+valor1+'_'+valor2).focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese el titulo',
          })
        return false;
    }
    // if($('#categoria_'+valor1+'_'+valor2).val().trim()==''){
    //     $('#categoria_'+valor1+'_'+valor2).focus();
    //     Swal.fire({
    //         type: 'error',
    //         title: 'Oops...',
    //         text: 'Ingrese la categoria',
    //       })
    //     return false;
    // }
    if($('#descripcion_'+valor1+'_'+valor2).val().trim()==''){
        $('#descripcion_'+valor1+'_'+valor2).focus();
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
    $("input[name='minimo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
    $("input[name='maximo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
    $("input[name='precio_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
        url: $("#form_"+valor1+'_'+valor2).attr('action'),
        method: $("#form_"+valor1+'_'+valor2).attr('method'),
        data:new FormData($("#form_"+valor1+'_'+valor2)[0]),
        dataType:'json',
        contentType:false,
        cache:false,
        processData: false,
        beforeSend: function() {
            $('#rpt_form_'+valor1+'_'+valor2).html('');
            $('#rpt_form_'+valor1+'_'+valor2).html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
        },
        success:function(data){
            $('#rpt_form_'+valor1+'_'+valor2).html(data.mensaje);
            $('#rpt_form_'+valor1+'_'+valor2).addClass(data.nombre_clase);
            $("#form_"+valor1+'_'+valor2)[0].reset();
        }
        });
}
function buscar_servicios(ruc_rs){
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
                $('#servicios').html('');
                $('#servicios').html(data);
            }
         });
    }
}
function enviar_datos_editar(valor1,valor2){
    if($('#'+valor1+'_asociacion_id').val()==''){
        $('#ruc_rs').focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese un numero de ruc, razon social o nombre',
          })
        return false;
    }
    if($('#titulo_'+valor1+'_'+valor2).val().trim()==''){
        $('#titulo_'+valor1+'_'+valor2).focus();
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Ingrese el titulo',
          })
        return false;
    }
    // if($('#categoria_'+valor1+'_'+valor2).val().trim()==''){
    //     $('#categoria_'+valor1+'_'+valor2).focus();
    //     Swal.fire({
    //         type: 'error',
    //         title: 'Oops...',
    //         text: 'Ingrese la categoria',
    //       })
    //     return false;
    // }
    if($('#descripcion_'+valor1+'_'+valor2).val().trim()==''){
        $('#descripcion_'+valor1+'_'+valor2).focus();
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
    $("input[name='minimo_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
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
    $("input[name='maximo_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
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
    $("input[name='precio_"+valor1+'_'+valor2.replace("e", "n")+"[]']").each(function(indice, elemento) {
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
    var minimo=0;
    $("input[name='minimo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
    $("input[name='maximo_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
    $("input[name='precio_"+valor1+'_'+valor2+"[]']").each(function(indice, elemento) {
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
        url: $("#form_"+valor1+'_'+valor2).attr('action'),
        method: $("#form_"+valor1+'_'+valor2).attr('method'),
        data:new FormData($("#form_"+valor1+'_'+valor2)[0]),
        dataType:'json',
        contentType:false,
        cache:false,
        processData: false,
        beforeSend: function() {
            $('#rpt_form_'+valor1+'_'+valor2).html('');
            $('#rpt_form_'+valor1+'_'+valor2).html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
        },
        success:function(data){
            $('#rpt_form_'+valor1+'_'+valor2).html(data.mensaje);
            $('#rpt_form_'+valor1+'_'+valor2).addClass(data.nombre_clase);
            $("#form_"+valor1+'_'+valor2)[0].reset();
        }
        });
}
function borrar_servicio(id,atributo){

    Swal.fire({
        title: 'MENSAJE DEL SISTEMA',
        text: "¿Estas seguro de borrar el servicio?",
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
                url:'/admin/servicio/delete/'+id+'/'+atributo,
                // data:{id:id},
                success:function(data){
                    if(data==1){
                        Swal.fire(
                            'Borrado!',
                            'El servicio ha sido borrada.',
                            'success'
                        );
                        $('#servicio_'+id).fadeOut();
                    }
                    else if(data==0){
                        Swal.fire(
                            'Error!',
                            'Subo un error al borrar el servicio.',
                            'danger'
                        )
                    }
                }
             });
        }
      })
}

function filtro_reserva(campo,columna){
    $('#codigo_'+columna).addClass('d-none');
    $('#nombre_'+columna).addClass('d-none');
    $('#fechas_'+columna).addClass('d-none');
    $('#mes_anio_'+columna).addClass('d-none');

    $('#'+campo+'_'+columna).removeClass('d-none');

}

function confirmar(tipo_servicio,grupo_id,estado){
    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    if(estado==0)
        estado=1;
    else if(estado==1)
        estado=0;

    console.log('tipo_servicio:'+tipo_servicio+',grupo_id:'+grupo_id+',estado:'+estado);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'get',
        url:'/admin/reserva/grupo/confirmar/'+tipo_servicio+'/'+grupo_id+'/'+estado,
        // data:{id:id},
        success:function(data){
            console.log(data);
            if(data.rpt==1){
                $('#estado_'+tipo_servicio+'_'+grupo_id).val(data.estado);

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-dark');
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).removeClass('badge-success');
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-primary');
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).removeClass('btn-danger');

                $('#estado_span_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_span);
                $('#estado_span_'+tipo_servicio+'_'+grupo_id).html(data.estado_span);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).addClass(data.clase_confirmar);
                $('#confirmar_'+tipo_servicio+'_'+grupo_id).html(data.estado_confirmar);
            }
            else if(data.rpt==0){
                Swal.fire(
                    'Upps!',
                    'Subo un error, vuelva a intentarlo.',
                    'error'
                )
            }
        }
     });
}

function mostrar_provincias_servicios(departamento_id,categoria){
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
        url:'../mostrar-provincias',
        data:{departamento_id:departamento_id},
        success:function(data){
            $("select[name='provincia'").html('');
            $("select[name='provincia'").html(data.options);
        }
        });

    mostrar_proveedores(departamento_id,categoria);
    }
}
function mostrar_distritos_servicios(provincia_id){
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
        url:'../mostrar-distritos',
        data:{provincia_id:provincia_id},
        success:function(data){
            $("select[name='distrito'").html('');
            $("select[name='distrito'").html(data.options);
        }
        });
    }
}
function mostrar_comunidades_servicios(distrito_id,asociacion_id){
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
        url:'../mostrar-comunidades',
        data:{distrito_id:distrito_id},
        success:function(data){

            $("#comunidad_"+asociacion_id).html('');
            $("#comunidad_"+asociacion_id).html(data.options);
        }
        });
    }
}

function mostrar_proveedores(departamento_id,categoria){
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
        url:'../mostrar-proveedores',
        data:{departamento_id:departamento_id,categoria:categoria},
        beforeSend: function() {
            $("#lista_proveedores").html('');
            $("#lista_proveedores").html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>');
        },
        success:function(data){

            $("#lista_proveedores").html('');
            $("#lista_proveedores").html(data);
        }
        });

    }
}
var nro_proves=0;
function pasar_datos(clase){
   var resultArray = [];
//    $("input[name='proveedor_id[]']").each(function () {
//     resultArray.push($(this).val());
//    });
   resultArray=$("input[name='proveedor_id[]']").map(function(){ return this.value }).get();
console.log('resultArray:'+resultArray);
   $("input[name='proveedor[]']").each(function (index) {
        if($(this).is(':checked')){
            var valor=$(this).val();
            valor=valor.split('_');
            console.log('in array:'+jQuery.inArray( valor[0], resultArray ));
            if (jQuery.inArray( valor[0], resultArray ) == -1 ) {
                nro_proves++;
                var cadena='<div id="lista_proveedores_save_'+nro_proves+'" class="row">'+
                            '<div class="col-7 ">'+valor[1]+'</div>'+
                            '<div class="col-3 px-0 mx-0"><input type="hidden" name="proveedor_id[]" value="'+valor[0]+'"><input class="form-control" type="number" name="precio_proveedor[]" min="0" step="0.01"></div>'+
                            '<div class="col-2 px-0 mx-0"><button type="button" class="btn btn-danger" onclick="borrar_proveedor_save(\''+nro_proves+'\')"><i class="fas fa-trash"></i></button></div>'+
                        '</div>';
                $('#lista_proveedores_save').append(cadena);
            }
        }
    });

}
function borrar_proveedor_save(valor){
    $('#lista_proveedores_save_'+valor).remove();
}
