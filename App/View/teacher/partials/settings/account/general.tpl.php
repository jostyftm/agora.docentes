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
									echo $info['primer_nombre']." ".$info['segundo_nombre']
								?>
							</td>	
						</tr>	
						<tr>
							<td>
								<strong>Apellidos:</strong>
							</td>
							<td>
								<?php 
									echo $info['primer_apellido']." ".$info['segundo_apellido']
								?>
							</td>		
						</tr>
						<tr>
							<td>
								<strong>N° Documento: </strong>
							</td>
							<td>
								<?php
								echo $info['documento'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Coreo electronico: </strong>
							</td>
							<td>
								<?php
								echo $info['email'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Dirección: </strong>
							</td>
							<td>
								<?php
								echo $info['direccion'];
								?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Telefono: </strong>
							</td>
							<td>
								<?php
								echo $info['tel_fijo'];
								?>
							</td>
						</tr>
		  			</tbody>
		  		</table>
		  	</div>
		  	<div class="panel-footer text-center">
		  		<a href="#">
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
		  		<a href="">
		  			Editar Contraseña
		  		</a>
		  	</div>
		 </div>
	</div>
</div>