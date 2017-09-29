<div class="row">
	<div class="col-md-12">
		<form action="/Asignature/storeObservation" id="formObsAsig" method="POST" enctype="application/x-www-form-urlencoded">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="">Observación</label>
						<textarea id="obsAsig">
							<?= (isset($observation['observacion'])) ? $observation['observacion'] : ''?>
						</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="form-group">
						<input type="hidden" name="id_student" id="id_studentFrm" value="<?= $id_student?>">
						<input type="hidden" name="id_asignature" id="id_asignatureFrm" value="<?= $id_asignature?>">
						<input type="hidden" name="period" id="periodFrm" value="<?= $period?>">
						<button type="submit" id="btnSubmit" class="btn btn-primary" >Guardar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>

	$(function(){

		// 
		CKEDITOR.replace( 'obsAsig' );

		// 
		$("#formObsAsig").submit(function(e){
			e.preventDefault();

			var that = $(this),
				modal = $("#modalAggObs"),
                btnSubmit = $("#btnSubmit"),
                period = $("#periodFrm").val(),
                id_student = $("#id_studentFrm").val(),
                backBtn = modal.find(".modal-footer a"),
                id_asignature = $("#id_asignatureFrm").val(),
                observation = CKEDITOR.instances.obsAsig.getData();

            $.ajax({
                type: 'POST',
                url: "/Asignature/storeObservations",
                dataType: 'html',
                data: {
                    id_student,
                    id_asignature,
                    period,
                    observation
                },
                beforeSend: function(xhr){
                	
                	btnSubmit.text('');
                	btnSubmit.append(
                		$('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
                        $('<span>Creando Observación...</span>')
                	);
                	btnSubmit.prop('disabled', true);
                },
                success: function(data){
					modal.modal('hide');
                },
                error(xhr, estado){
                    console.log(xhr);
                    console.log(estado);
                }
            });
            
		});
	})
</script>