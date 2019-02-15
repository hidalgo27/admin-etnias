

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
function borrar_foto_cliente(id){
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
