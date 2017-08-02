<div class="col-md-12">
	<table class="table table-striped" id="tabla">
		<thead>
			<tr>
				<th>N°</th>
				<th>Apellidos y nombres estudiantes</th>
				<th>Superación</th>
				<th>Periodo <?= $period;?></th>
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
						<strong>
							<span class="bold"><?= $student['periodo']?>
							</span>
						</strong>
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
        		period = <?= $period?>;
        	
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
			         	period, id_student,id_asignature,id_group, oldContent,newContent
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