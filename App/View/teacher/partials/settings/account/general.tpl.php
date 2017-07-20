<!-- <?= print_r($info);?> -->
<div class="row" >
	<div class=" col-md-6 content">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h4>
					<i class="fa fa-user"></i>
				<span>Información personal</span>
				</h4>
			</div>
		  	<div class="panel-body">
		  		<table class="table">
		  			<tbody>
						<tr>
							<td>
								<strong>Nombre:</strong>
							</td>
							<td>
								<?php 
									echo $teacher['primer_nombre']." ".$teacher['segundo_nombre']
								?>
							</td>	
						</tr>	
						<tr>
							<td>
								<strong>Apellidos:</strong>
							</td>
							<td>
								<?php 
									echo $teacher['primer_apellido']." ".$teacher['segundo_apellido']
								?>
							</td>		
						</tr>
						<tr>
							<td>
								<strong>N° Documento: </strong>
							</td>
							<td>
								<?php
								echo $teacher['documento'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Coreo electronico: </strong>
							</td>
							<td>
								<?php
								echo $teacher['email'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Dirección: </strong>
							</td>
							<td>
								<?php
								echo $teacher['direccion'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Celular: </strong>
							</td>
							<td>
								<?php
								echo $teacher['tel_celular'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Telefono: </strong>
							</td>
							<td>
								<?php
								echo $teacher['tel_fijo'];
								?>
							</td>
						</tr>
		  			</tbody>
		  		</table>
		  	</div>
		  	<div class="panel-footer text-center">
		  		<a href="#" id="editInfo">
		  			Editar Información Personal
		  		</a>
		  	</div>
		</div>
	</div>
	<div class="col-md-5 content">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h4>
					<i class="fa fa-key"></i>
				<span>Contraseña</span>
				</h4>
			</div>
		  	<div class="panel-body">
		  		<table class="table">
		  			<tr>
		  				<td>
		  					<strong>Contraseña:</strong>
		  				</td>
		  				<td>
		  					**************
		  				</td>
		  			</tr>
		  		</table>
		  	</div>
		  	<div class="panel-footer text-center">
		  		<a href="" id="editPassword">
		  			Editar Contraseña
		  		</a>
		  	</div>
		 </div>
	</div>
</div>

<!-- Modal Edit Info -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<form action="/Settings/updateInfo" method="POST" enctype="application/x-www-form-urlencoded" id="formEditInfo">
      			<div class="modal-header">
	        		<h4 class="modal-title" id="myModalLabel">Editar Información</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="row">
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Primer Nombre</label>
	      						<input type="text" name="data[primer_nombre]" class="form-control" value="<?php echo $teacher['primer_nombre'];?>">
	      					</div>
	      				</div>
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Segundo Nombre</label>
	      						<input type="text" name="data[segundo_nombre]" class="form-control" value="<?php echo $teacher['segundo_nombre'];?>">
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Primer Apellido</label>
	      						<input type="text" name="data[primer_apellido]" class="form-control" value="<?php echo $teacher['primer_apellido']?>">
	      					</div>
	      				</div>
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Segundo Apellido</label>
	      						<input type="text" name="data[segundo_apellido]" class="form-control" value="<?php echo $teacher['segundo_apellido'];?>">
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">N° Documento</label>
	      						<input type="text" name="" class="form-control" value="<?php echo $teacher['documento'];?>" disabled>
	      					</div>
	      				</div>
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Correo Electronico</label>
	      						<input type="text" name="data[email]" class="form-control" value="<?php echo $teacher['email'];?>">
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Celular</label>
	      						<input type="text" name="data[tel_celular]" class="form-control" value="<?php echo $teacher['tel_celular'];?>">
	      					</div>
	      				</div>
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Telefono</label>
	      						<input type="text" name="data[tel_fijo]" class="form-control" value="<?php echo $teacher['tel_fijo'];?>">
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-6">
	      					<div class="form-group">
	      						<label for="">Dirección</label>
	      						<input type="text" name="data[direccion]" class="form-control" value="<?php echo $teacher['direccion'];?>">
	      					</div>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="modal-footer">
	      			<input type="hidden" name="request" value="crud">
	      			<input type="hidden" name="role" value="teacher">
	      			<input type="hidden" name="documento" value="<?php echo $teacher['documento'];?>">
	      			<input type="hidden" name="id_teacher" id="id_teacher" value="<?php echo $teacher['id_docente'];?>">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        		<button type="submit" class="btn btn-primary">Actualizar</button>
	      		</div>
      		</form>
    	</div>
  	</div>
</div>
<!--  -->

<!-- Modal Edit Password -->
<div class="modal fade" id="modalEditPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
      		<form action="/Settings/updatePassword" method="POST" enctype="application/x-www-form-urlencoded" id="formEditPassword">
      			<div class="modal-header">
	        		<h4 class="modal-title" id="myModalLabel">Editar Contraseña</h4>
	      		</div>
	      		<div class="modal-body">
	      			<div class="row">
	      				<div class="col-md-12">
	      					<div class="form-group">
	      						<label for="">Contraseña Actual</label>
	      						<input type="password" name="password" class="form-control" >
	      						<strong><span></span></strong>
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-12">
	      					<div class="form-group">
	      						<label for="">Nueva Contraseña</label>
	      						<input type="password" name="newPassword" class="form-control">
	      						<strong><span></span></strong>
	      					</div>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-12">
	      					<div class="form-group">
	      						<label for="">Repita la contraseña</label>
	      						<input type="password" name="password_confirm" class="form-control">
	      						<strong><span></span></strong>
	      					</div>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="modal-footer">
	      			<input type="hidden" name="request" value="crud">
	      			<input type="hidden" name="role" value="teacher">
	      			<input type="hidden" name="documento" value="<?php echo $teacher['documento'];?>">
	      			<input type="hidden" name="id_teacher" id="id_teacher" value="<?php echo $teacher['id_docente'];?>">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        		<button type="submit" id="btnUpdatePass" class="btn btn-primary" disabled>Actualizar Cotraseña</button>
	      		</div>
      		</form>
    	</div>
  	</div>
</div>
<!--  -->

<script>

	$("#editPassword").click(function(e){
		e.preventDefault();

		$('#modalEditPass').modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		})
	});
	
	$("input[name=newPassword]").keyup(function(e){
		var that = $(this),
			next = that.next().find('span'),
			Dlength = that.val().length;

		if(Dlength == 0 ){
			next.removeClass();
			next.text('');

		}else if(Dlength > 0 && Dlength <= 5){
			next.removeClass().addClass('show text-center text-danger');
			next.text('La contraseña debil');

		}else if(Dlength > 5 && Dlength <= 9){
			next.removeClass().addClass('show text-center text-warning');
			next.text('La contraseña no es tan segunra');
		}else if(Dlength > 10){
			next.removeClass().addClass('show text-center text-success');
			next.text('La contraseña segura');
		}
	});

	$("input[name=password_confirm]").keyup(function(e){

		var that = $(this),
			cPassword = $(this).val(),
			nPassword = $("input[name=newPassword]").val(),
			next = that.next().find('span'),
			btnUpdate = $("#btnUpdatePass");

		console.log('cp: '+cPassword+' nP: '+nPassword);

		if(cPassword.length == 0){
			next.removeClass();
			next.text('');
			btnUpdate.prop('disabled', true);
		}if(cPassword.length > 0 && cPassword === nPassword){
			next.removeClass().addClass('show text-center text-success');
			next.text('Las contraseñas coinciden');
			btnUpdate.prop('disabled', false);
		}else{
			next.removeClass().addClass('show text-center text-danger');
			next.text('Las contraseñas no coinciden');
			btnUpdate.prop('disabled', true);
		}

	});

	$("#formEditPassword").submit(function(e){
		e.preventDefault();
		var that = $(this);

		$.ajax({
			type: that.attr('method'),
			url: '/Settings/checkPassword',
			dataType: 'json',
			data: that.serialize(),
			beforeSend: function(xhr){
				that.find("button[type=submit]").text('');
				that.find("button[type=submit]").append(
					$('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
					$('<span>Verificando Contraseña</span>')
				);
				that.find("button").prop('disabled', true);
			},
			success: function(data){

				if(data.state){

					$.ajax({
						type: that.attr('method'),
						url: that.attr('action'),
						dataType: 'html',
						data: that.serialize(),
						beforeSend: function(xhr){
							that.find("button[type=submit]").text('');
							that.find("button[type=submit]").append(
								$('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
								$('<span>Actualizando Contraseña</span>')
							);
							that.find("button").prop('disabled', true);
						},
						success: function(data){
							that.find("button").prop('disabled', false);

							$('#modalEditPass').modal('toggle');
							
							if($(".modal-backdrop") && $('body').hasClass('modal-open') ){
								$(".modal-backdrop").remove();
								$('body').removeClass('modal-open');
							}

							$("#content").empty().append(data);
						},
						error: function(xhr, estate){
							console.log(xhr);
					        console.log(estate);
						}

					});
					
				}else{
					var next = $("input[name=password]").next().find('span'),
						btnUpdate = that.find("button[type=submit]");

					next.removeClass().addClass('show text-center text-danger');
					next.text('Contraseña incorrecta');

					btnUpdate.prop('disabled', false);
					btnUpdate.empty().append(
						$('<span>Actualizar Contraseña</span>')
					);
				}
			},
			error: function(xhr, estate){
				console.log(xhr);
		        console.log(estate);
			}
		});
	});

	// 
	$("#editInfo").click(function(e){
		e.preventDefault();

		$('#modalEdit').modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		})
	});

	$("#formEditInfo").submit(function(e){
		e.preventDefault();

		var that = $(this);

		$.ajax({
			type: that.attr('method'),
			url: that.attr('action'),
			dataType: 'html',
			data: that.serialize(),
			beforeSend: function(xhr){
				that.find("button[type=submit]").text('');
				that.find("button[type=submit]").append(
					$('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
					$('<span>Actualizando...</span>')
				);
				that.find("button").prop('disabled', true);
			},
			success: function(data){
				that.find("button[type=submit]").empty().append(
					$('<i>', {class: 'fa fa-check fa-fw'}),
					$('<span>Actualizado</span>')
				);
				that.find("button").prop('disabled', false);

				$('#modalEdit').modal('toggle');
				
				if($(".modal-backdrop") && $('body').hasClass('modal-open') ){
					$(".modal-backdrop").remove();
					$('body').removeClass('modal-open');
				}

				$("#content").empty().append(data);
			},
			error: function(xhr, estate){
				console.log(xhr);
		        console.log(estate);
			}
		});
	});
</script>