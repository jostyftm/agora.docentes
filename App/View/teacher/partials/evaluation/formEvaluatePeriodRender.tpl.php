<div class="col-md-12">
	<table class="table table-striped" id="tabla">
	    <thead>
	       	<tr>
	            <th width="50px">N°</th>
	            <th width="400px">Nombre</th>
	            <th width="100px">Periodo: <?php echo split("_", $periodo)[1] ?></th>
	        </tr>
	    </thead>
	    <tbody id="cuerpoTabla">
	    <?php
	        foreach($students  as $clave => $valor): ?>
		        <tr class="inputs">
		      	   <td><?= ($clave+1) ?></td>
						<td>
                     <?=
								$valor['primer_ape_alu']." ".$valor['segundo_ape_alu']." ".
								$valor['primer_nom_alu']." ".$valor['segundo_nom_alu']
                     ?>
						</td>
                  <td class='editable'>
                     <div class="form-group">
                        <input data-student="<?= $valor['idstudents'] ?>" data-asignatura="<?= $valor['id_asignatura']?>" data-periodo="<?= $periodo?>" type='text' value="" class='form-control'/>
                        <label class="control-label"></label>
                     </div>
                  </td>
		         </tr>
	        
	    <?php endforeach; ?>
	    </tbody>
	</table>
</div>

<script>
	// DataTables
    $('#tabla').dataTable({
      	"lengthChange": false,
       	"paging": false,
        language: {
        	url: '/Public/json/Spanish.json'
        }
    });	

    // 
    $(function(){

        $("input").keydown(function(event){

          console.log(event.which);
          
        	if(event.which == 40){
        		var ele = $(this).parent().parent().parent().next().find("input");
        		ele.focus();
        	}else if(event.which == 38){
        		var ele = $(this).parent().parent().parent().prev().find("input");
        		ele.focus();
        	}
        });

        $("td input").focus(function(){
            var oldContent = $(this).val();
            this.select();

            $(this).blur(function() {
                var that = $(this),
                newContent = $(this).val().replace(',', '.'),
                id_estudiante = $(this).attr('data-student'),
                id_asignatura = $(this).attr('data-asignatura'),
                periodo = $(this).attr('data-periodo');

                if(newContent != oldContent){
                    $(this).attr("value", newContent);
                    // actualizarPeriodo(periodo, id_estudiante,id_asignatura,newContent);
                    $.ajax({
                     type: "GET",
                     dataType: "json",
                     url: '/teacher/updatePeriod/'+periodo+'/'+id_estudiante+'/'+id_asignatura+'/<?= $id_group ?>/'+newContent+'/<?= $groupType ?>',
                     beforeSend: function(){
                        that.next().text("Guardando Cambios");
                        that.prop('disabled', true);
                     },
                     success: function(data){
                        
                        if(data.state == true){

                           that.next().text("");
                           that.prop('disabled', false);

                           if(that.parent().hasClass('has-error'))
                              that.parent().removeClass('has-error');

                        }else{

                           that.next().text(data.mensaje);
                           that.prop('disabled', false);

                           if(!that.parent().hasClass('has-error'))
                              that.parent().addClass('has-error');
                        }

                        console.log(data.state);
                     },
                     error(xhr, estado){
                        console.log(xhr);
                        console.log(estado);
                     }
                  });
                }
                $(this).unbind("blur");
            });
        });

        function actualizarPeriodo(periodo, id_estudiante, id_asignatura, valor){
            $.ajax({

            type: "GET",
            // dataType: "json",
            url: '/teacher/updatePeriod/'+periodo+'/'+id_estudiante+'/'+id_asignatura+'/<?= $id_group ?>/'+valor+'/<?= $groupType ?>',

            success: function(data){
               
               if(data.state == true){

               }else{

               }

               console.log(data);
            },
            error(xhr, estado){
               console.log(xhr);
               console.log(estado);
            }
         });
        }
    });
</script>