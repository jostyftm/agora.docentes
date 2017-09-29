<div class="col-md-12">
	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th>N°</th>
				<th>Apellidos y nombres estudiantes</th>
				<th>Superación</th>
				<th>Nota superacion</th>
				<th>Periodo <?= $period;?></th>
				<th>Observación</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($students as $key => $student): ?>
				<tr class="inputs">
					<td><?= ($key+1) ?></td>
					<td><?= $student['primer_ape_alu']." ".$student['segundo_ape_alu']." ".$student['primer_nom_alu']." ".$student['segundo_nom_alu']; ?>
					</td>
					<td>
						<div class="form-group">
							<input type="text" name="period_<?= $student['idstudents']?>" data-student="<?= $student['idstudents']?>"  data-old="<?= $student['periodo']?>" value="" class="form-control">
							<label class="control-label"></label>
						</div>
					</td>
					<td>
						<?php
							$nota_supe = 0;

							if(!empty($respRecovery)):

								foreach($respRecovery as $key => $recovery):

									if($student['idstudents'] == $recovery['id_estudiante']):
										$nota_supe = $recovery['nota'];
									endif;

								endforeach;

							endif;
						?>
						<strong>
							<span class="bold">
								<?php
									echo (strlen($nota_supe) == 1) ? $nota_supe.'.0' : $nota_supe
								?>
							</span>
						</strong>
					</td>
					<td>
						<strong>
							<span class="bold">
								<?php
									echo (strlen($student['periodo']) == 1) ? $student['periodo'].'.0' : $student['periodo']
								?>
							</span>
						</strong>
					</td>
					<td>
						<a data-student="<?= $estudiante?>" data-id="<?=$row['id_estudiante']?>" data-click="aggObsAsig" data-request="openModal" class="btn btn-primary btn-sm" title="Agregar Observación en la Asignatura">
							<i class="fa fa-user-plus"></i>
						</a>
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

	$("input").keydown(function(event){
       	if(event.which == 40){
       		var ele = $(this).parent().parent().parent().next().find("input");
       		ele.focus();
       	}else if(event.which == 38){
       		var ele = $(this).parent().parent().parent().prev().find("input");
       		ele.focus();
      	}
    });

    $("td input").focus(function(){
        	var oldContent = $(this).attr('data-old'),
        		id_group = <?= $id_group?>.
        		id_asignature = <?= $id_asignature?>,
        		period = <?= $period?>,
        		typeGroup = "<?= $type ?>";
        	
        	this.select();
        	
        $(this).blur(function() {
            var that = $(this),
            	newContent = $(this).val().replace(',', '.'),
            	id_student = $(this).attr('data-student');

            if(newContent != oldContent && newContent > 0){
               $(this).attr("value", newContent);
               $(this).attr("data-old", newContent);

               $.ajax({
               	type: "POST",
			         dataType: "json",
			         url: '/evaluation/updateGroupRecovery',
			         data:{
			         	period, id_student,id_asignature,id_group, oldContent,newContent, typeGroup
			         },
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

			         		that.parent().parent().next().find('span').text(newContent);
			         	}else{

			         		that.next().text(data.mensaje);
			         		that.prop('disabled', false);

			         		if(!that.parent().hasClass('has-error'))
			         			that.parent().addClass('has-error');
			         	}

			           	that.val('');
			           	console.log(data);
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
</script>