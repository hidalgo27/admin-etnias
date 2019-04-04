<input type="text" id="fecha_a_lista_{{ $item->id }}" name="fecha" class="form-control datepicker-here d-none" data-language='en'>
<script>
    var eventDates_{{ $item->id }}=new Array();
    var eventDates_d_{{ $item->id }}=new Array();
    @foreach($item->disponibilidad as $disponible)
        if({{ $disponible->estado }}=='1'){
            eventDates_{{ $item->id }}.push('{{ $disponible->fecha}}');
        }
        else{
            eventDates_d_{{ $item->id }}.push('{{ $disponible->fecha}}');
        }
    @endforeach

    console.log('eventDates:'+eventDates_{{ $item->id }});
    $picker = $('#fecha_a_lista_{{ $item->id}}');
    {{--  $picker = $('.datepicker-here');  --}}

    $content = $('#custom-cells-events');
    sentences = [];

    $picker.datepicker({
        inline:true,
        {{-- language: 'es', --}}
        onRenderCell: function (date, cellType) {
            console.log('recorrido onRenderCell:{{ $item->id}}');
            var currentDate = date.getDate();
            var mes=date.getMonth()+1;
            mes=mes < 10 ? '0'+mes : mes;
            var dia=date.getDate();
            dia=dia < 10 ? '0'+dia : dia;
            var fecha=date.getFullYear()+'-'+mes+'-'+dia;
            // Add extra element, if `eventDates` contains `currentDate`
            if (cellType == 'day' && eventDates_{{ $item->id }}.indexOf(fecha) != -1) {
                return {
                    html: '<span class="dp-note">'+currentDate+'</span>'
                }
            }
            else if(cellType == 'day' && eventDates_d_{{ $item->id }}.indexOf(fecha) != -1){
                return {
                    html: '<span class="dp-note_2">'+currentDate+'</span>'
                }
            }
        },
        onSelect: function onSelect(fd, date) {
            var fe=fd.split('/');
            console.log('recorrido onSelect:{{ $item->id}}'+date+'_'+fd);
            var title = '', content = ''
            // If date with event is selected, show it
            var mes=date.getMonth()+1;
            mes=mes < 10 ? '0'+mes : mes;
            var dia=date.getDate();
            dia=dia < 10 ? '0'+dia : dia;
            var fecha=date.getFullYear()+'-'+mes+'-'+dia;

            if (date && eventDates_{{ $item->id }}.indexOf(fecha) != -1) {
                title =fe[1]+'-'+fe[0]+'-'+fe[2];
                content = sentences[Math.floor(Math.random() * eventDates_{{ $item->id }}.length)];
            }
            $('#fecha_texto_{{ $item->id }}').html(title)
        }
    });
</script>
