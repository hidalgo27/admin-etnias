

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
function agregar_precio_actividad(){
    $('#actividad_precios').append('');

}
function borrar_precio_actividad(){
    $('#actividad_precios').append('');

}
