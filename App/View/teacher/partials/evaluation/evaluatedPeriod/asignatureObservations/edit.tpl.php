<div class="row">
	<div class="col-md-12">
		<form action="/Asignature/updateObservation" id="updateformObsAsig" method="POST" enctype="application/x-www-form-urlencoded">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="">Observación</label>
						<textarea id="updateObsAsig"><?= $observation['observacion']?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="form-group">
						<input type="hidden" name="id_observation" id="id_observation" value="<?= $observation['id']?>">
						<button type="submit" class="btn btn-primary" id="btnSubmit">Actualizar Observación</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>

	$(function(){

		// 
		CKEDITOR.replace( 'updateObsAsig' );

		// 
		$("#updateformObsAsig").submit(function(e){
			e.preventDefault();

			var that = $(this),
				modal = $("#modalAggObs"),
				btnSubmit = $("#btnSubmit"),
                backBtn = modal.find(".modal-footer a"),
                id_observation = $("#id_observation").val(),
                observation = CKEDITOR.instances.updateObsAsig.getData();

            $.ajax({
                type: that.attr('method'),
                url: that.attr('action'),
                dataType: 'html',
                data: {
                    id_observation,
                    observation
                },
                beforeSend: function(xhr){
                	btnSubmit.text('');
                	btnSubmit.append(
                		$('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
                        $('<span>Actualizando Observación...</span>')
                	);
                	btnSubmit.prop('disabled', true);
                },
                success: function(data){
					backBtn.click();	
                },
                error(xhr, estado){
                    console.log(xhr);
                    console.log(estado);
                }
            });
            
		});
	})
</script>