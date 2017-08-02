<div class="row" >
	<div class="col-md-12 content">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-info-circle" aria-hidden="true"></i>
					Fecha 
					<?php 
					date_default_timezone_set("America/Bogota");
					echo date("Y-m-d"); 
					?> 
				</h3> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-4">
						Asignatura: <p><?=$titulos['asignatura'];?></p>
					</div>
					<div class="col-lg-4">
						Grupo:<p> <?=$titulos['nombre_grupo'];?></p>
					</div>
					<div class="col-lg-4">
						<form action="">
							<div class="form-group">

								<?php
								date_default_timezone_set("America/Bogota");
								$time = date("Y-m-d");
								foreach($periodos as $key => $value){
									$timeInicio = $value['apertura'];
									$timeCierre = $value['cierre'];
									if($timeInicio < $time and $time < $timeCierre){
										echo '<input type=hidden id=periodoDB value='.$value['periodos'].'>';
									}
								}
                                        //var_dump($periodos);
								?>

								<label for="">PERIODO</label>
								<select name="" id="periodos" class="form-control">
									<option selected value="0">SELECCIONAR PERIODO</option>
                                    <?php

                                    foreach ($periodos as $key => $value) {
                                        if($value['periodos']==1){
                                            echo '<option value="'.$value['periodos'].'">Periodo '.$value['periodos'].'</option>';
                                        }else{
                                            echo '<option value="'.$value['periodos'].'">Periodo '.$value['periodos'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-lg-4">
						<div id="content-control" class="control-desp hidden">
							<a href="#" id="btn-up" class="medio-vertical btn btn-default btn-xs"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
							<a href="#" id="btn-down" class="medio-vertical btn btn-default btn-xs"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
							<a href="#" id="btn-left" class="medio-horinzontal btn btn-default btn-xs"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
							<a href="#" id="btn-right" class="medio-horinzontal btn btn-default btn-xs"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
							<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css"> -->
						</div>
					</div>
					<div class="col-lg-4">
						<div class="titles-center">
							<button id="button-desempeno" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" disabled >
								Configurar Desempeño
							</button>
							<!--
							<button id="button-criterios" type="button" data-toggle="modal" data-target="#modal-critetios" class="btn btn-warning">
								Configurar Criterios
							</button>
						-->

						<a href="/teacher" id="" type="button"  class="btn btn-danger">
							Salir
						</a>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="titles-center">
						<!--
							<button type="button" class="btn btn-danger">Salir</button>
							<button type="button" class="btn btn-default">PDF</button>
							<button type="button" class="btn btn-default">
								<i class="fa fa-print" aria-hidden="true"></i>
							</button>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!--  -->
<div id="" class="row row-table">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body" >
				<div class="table-responsive" id="contenedorTabla">
					
				</div>
			</div>
		</div>
	</div>
</div> 


<!--  -->
<input type="hidden" id="gradoDB" value="<?=$grado; ?>">
<input type="hidden" id="grupoDB" value="<?php echo $grupo ?>">
<input type="hidden" id="asignaturaDB" value="<?php echo $asignatura ?>">
<input type="hidden" id="databaseDB" value="<?php echo $database?>">
<input type="hidden" id="minimo" value="<?php echo $valoracion[1]['minimo'] ?>">
<input type="hidden" id="maximo" value="<?php echo $valoracion[3]['maximo'] ?>">


<input type="hidden" id="porcentaje_grupo1" value="<?=$porcentajes['porcentaje_grupo1']; ?>">
<input type="hidden" id="porcentaje_grupo2" value="<?=$porcentajes['porcentaje_grupo2']?>">
<input type="hidden" id="porcentaje_grupo3" value="<?=$porcentajes['porcentaje_grupo3']?>">
<input type="hidden" id="porcentaje_autoeva" value="<?=$porcentajes['porcentaje_autoevaluacion']?>">
<input type="hidden" id="porcentaje_proyect" value="<?=$porcentajes['porcentaje_efp']?>">

<input type="hidden" id="porcentaje_ep" value="<?=$porcentajeDefinidos[0]['porcentaje']?>">
<input type="hidden" id="porcentaje_ex" value="<?=$porcentajeDefinidos[1]['porcentaje']?>">
<input type="hidden" id="porcentaje_tt" value="<?=$porcentajeDefinidos[2]['porcentaje']?>">
<input type="hidden" id="porcentaje_par" value="<?=$porcentajeDefinidos[3]['porcentaje']?>">
<input type="hidden" id="porcentaje_ad" value="<?=$porcentajeDefinidos[4]['porcentaje']?>">

<!--  -->
<input type="hidden" id="url" value="<?php echo $_GET['url'];?>">

<!-- MODAL PARA CONFIGURAR CRITERIOS FIJOS-->
<div class="modal fade" role="dialog" tabindex="-1" role="dialog" id="modal-critetios">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="container">
				<div id="content-btn-criterios" class="row">
					<div  class="col-md-6">
						<br>
						<table class="table table-striped">
							<tr >
								<th colspan="4" class="bg-primary">
									<center> DESEMPEÑO PERSONAL </center>
								</th>
							</tr>
							<tr>
								<th>#</th>
								<th>ABREVIACIÓN</th>
								<th>CRITERIO</th>
								<th>ACCIONES</th>
							</tr>


							<?php
							$contCriterios=1;
								//var_dump($criterios);
							foreach ($criterios as $key => $value){

								if($value['desempeno']=='PERSONAL') {
									?>
									<tr>
										<td><?=$contCriterios?></td>
										<td>
											<div class="form-group">
												<div class="col-sm-10">
													<input type="text" data-criterio="<?=$value['posicion']?>" maxlength="3" data-name="abreviacion" readonly class="form-control " value="<?= $value['abreviacion']; ?>">
												</div>
											</div>
										</td>
										<td>

											<input type="text" class="form-control " data-name="criterio"  readonly data-criterio="<?=$value['posicion']?>"  value="<?= $value['criterio']; ?>">
										</td>
										<td> 
											<span id="<?=$value['posicion']?>" class="btn btn-success hidden"><i class="fa fa-check" aria-hidden="true"></i></span>
											<a href="#" id="<?=$value['posicion']?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>

										</td>
									</tr>

									<?php
									$contCriterios++;
								}
							}

							?>

						</table>



					</div>
					<div class="col-md-6">
						<br>
						<table class="table table-striped">
							<tr >
								<th colspan="4" class="bg-warning">
									<center> DESEMPEÑO SOCIAL </center>
								</th>
							</tr>
							<tr>
								<th>#</th>
								<th>ABREVIACIÓN</th>
								<th>CRITERIO</th>
								<th>ACCIONES</th>
							</tr>


							<?php
							$contCriterios=1;
							foreach ($criterios as $key => $value){

								if($value['desempeno']=='SOCIAL') {
									?>
									<tr>
										<td><?=$contCriterios?></td>
										<td>
											<div class="form-group">
												<div class="col-sm-10">
													<input type="text" data-criterio="<?=$value['posicion']?>" maxlength="3" data-name="abreviacion"  readonly class="form-control" value="<?= $value['abreviacion']; ?>">
												</div>
											</div>
										</td>
										<td>
											<input type="text" class="form-control" data-name="criterio" readonly data-criterio="<?=$value['posicion']?>"  value="<?= $value['criterio']; ?>">
										</td>
										<td> 
											<span id="<?=$value['posicion']?>" class="btn btn-success hidden"><i class="fa fa-check" aria-hidden="true"></i></span>
											<a href="#" id="<?=$value['posicion']?>" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>



										</td>
									</tr>

									<?php
									$contCriterios++;
								}
							}

							?>

						</table>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn-finalizar" class="btn btn-success" data-dismiss="modal">CERRAR</button>
						<br>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<!-- FIN MODAL CRITERIOS-->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Listado de Indicadores de desempeño</h4>
			</div>
			<div class="modal-body">
				<form action="" id="form-select">
					<div class="row" id="div-option">
						<div class="col-lg-3">
							<div class="form-group">
								<label for="">ASIGNATURA</label>
								<select name="asignaturaSelect" id="" class="form-control">
									<option selected value="0">Selecciona una Asignatura</option>

									<?php

									foreach ($asignaturas as $key => $value) {
										if($value['id_asignatura']==$asignatura){
											echo '<option value="'.$value['id_asignatura'].'" selected>'.$value['asignatura'].'</option>';
										}else{
											echo '<option value="'.$value['id_asignatura'].'">'.$value['asignatura'].'</option>';
										}											

									}
									?>	
									<option value="-1">TODOS</option>																		
								</select>
							</div>

						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label for="">GRADO</label>
								<select name="gradoSelect" id="" class="form-control">
									<option selected value="0">Selecciona un Grado</option>
									<?php

									foreach ($grados as $key => $value) {
										if($value['id_grado']==$grado){
											echo '<option value="'.$value['id_grado'].'" selected>'.$value['grado'].'</option>';
										}else{
											echo '<option value="'.$value['id_grado'].'">'.$value['grado'].'</option>';
										}											

									}
									?>	
									<option value="-1">TODOS</option>												
								</select>
							</div>

						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label for="">CATEGORIA</label>
								<select name="categoriaSelect" id="" class="form-control">
									<option selected value="0">Selecciona un Categoria</option>
									<?php

									foreach ($categorias as $key => $value) {
										if($value['id_saber_chs']==1){
											echo '<option value="'.$value['id_saber_chs'].'" selected>'.$value['saber'].'</option>';
										}else{
											echo '<option value="'.$value['id_saber_chs'].'">'.$value['saber'].'</option>';
										}											

									}

									?>	

								</select>
							</div>

						</div>

						<div class="col-lg-3">									
							<div class="form-group">
								<label for="">Periodo</label>
								<select name="periodoSelect" id="periodos" class="form-control">
									<option selected value="0">Selecciona un Periodo</option>
									<?php

									foreach ($periodos as $key => $value) {
										if($value['periodos']==1){
											echo '<option value="'.$value['periodos'].'" selected>'.$value['periodos'].'</option>';
										}else{
											echo '<option value="'.$value['periodos'].'">'.$value['periodos'].'</option>';
										}								
									}
									?>	
									<option value="-1">TODOS</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<button type="button" id="btn-crear-desemp" class="btn btn-success btn-md btn-block"> 
								<i class="fa fa-plus" aria-hidden="true"></i>
								CREAR NUEVO DESEMPEÑO
							</button>
							<br>
						</div>
						<div class="col-lg-6">
							<input type="hidden" id="cantidadDC" value="5">

							<div id="content-div-dc" class="desemp-visible">
								<span data-n="1">178 <i class="fa fa-times" aria-hidden="true"></i> </span>
								<span data-n="2">23 <i class="fa fa-times" aria-hidden="true"></i> </span>
								<span data-n="3">389 <i class="fa fa-times" aria-hidden="true"></i></span>
								<span data-n="4">41 <i class="fa fa-times" aria-hidden="true"></i></span>
								<span data-n="5">5 <i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
							<div id="content-div-dc" class="desemp-hidden"></div>
							<div id="content-div-dc" class="desemp-hidden"></div>
							<br>
						</div>
					</div>
				</form>












				<!-- FORMULARIO PARA CREAR UN NUEVO DESEMPEÑO-->
				<form>


					<div id="content-formulario-registro">

						<div class="row">


							<div class="col-lg-2">

								<div class="form-group">
									<label for="">GRADO</label>
									<select name="gradoInsertar" id="gradoInsertar" required class="form-control">


										<?php

										foreach ($grados as $key => $value) {

											echo '<option value="'.$value['id_grado'].'">'.$value['grado'].'</option>';												

										}
										?>
									</select>
								</div>

							</div>
							<div class="col-lg-3">

								<div class="form-group">
									<label for="">AREA</label>
									<select name="AreaInsertar" id="AreaInsertar" required class="form-control">
										<option selected value="0">Seleccionar Area</option>

									</select>
								</div>

							</div>
							<div class="col-lg-3">

								<div class="form-group">
									<label for="">ASIGNATURA</label>
									<select name="AsigInsertar" id="AsigInsertar" required class="form-control">
										<option selected value="0">Seleccionar Asignatura</option>

									</select>
								</div>

							</div>
							<div class="col-lg-1">

								<div class="form-group">
									<label for="">PERIODO</label>
									<select name="periodoInsertar" id="periodoInsertar" required class="form-control">

										<?php

										foreach ($periodos as $key => $value) {

											echo '<option value="'.$value['periodos'].'">'.$value['periodos'].'</option>';

										}
										?>

									</select>
								</div>

							</div>

							<div class="col-lg-3">

								<div class="form-group">
									<label for="">CATEGORIA</label>
									<select name="categoriaInsertar" id="categoriaInsertar" required class="form-control">

										<?php

										foreach ($categorias as $key => $value) {

											echo '<option value="'.$value['id_saber_chs'].'">'.$value['saber'].'</option>';


										}

										?>
									</select>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-lg-4">
								<br>
								<input type="submit" type="button" id="btn-guardar-desemp"  class="btn btn-success" value="GUARDAR">
								<button type="button"  id="btn-cancelar" class="btn btn-default" data-dismiss="modal"> CANCELAR</button>
								<br>
							</div>
							<div class="col-lg-8">

							</div>
						</div>
						<br>
						<div class="row">

							<div class="col-md-12 col-lg-6">
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Superior</label>
										<textarea id="text-desempeno" class="form-control" rows="3" ></textarea>
									</div> 
								</div>

								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Alto</label>
										<textarea class="form-control" id="text-alto" rows="3"></textarea>
									</div> 
								</div>

								
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Básico</label>
										<textarea class="form-control" id="text-basico" rows="3"></textarea>
									</div> 
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Bajo</label>
										<textarea class="form-control" id="text-bajo" rows="3"></textarea>
									</div> 
								</div>
							</div>


							<div class="col-md-12 col-lg-6">
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<br>
										<br>
										<br>
										<br>
										<br>
									</div> 
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<br>
										<br>
										<br>
										<br>
										<br>
									</div> 
								</div>

								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Recomendación de Mejoramiento</label>
										<textarea class="form-control" id="text-refuerzo" rows="3" ></textarea>
									</div> 
								</div>

								<div class="col-md-12 col-lg-12">
									<div class="form-group">
										<label for="comment">Recomendación de Superación</label>
										<textarea class="form-control" id="text-recomendacion" rows="3"></textarea>
									</div> 
								</div>		
							</div>



							<input type="hidden" id="t-alto" value="<?php echo $expresiones['alto']?> ">
							<input type="hidden" id="t-basico" value="<?php echo $expresiones['basico']?> ">
							<input type="hidden" id="t-bajo" value="<?php echo $expresiones['bajo']?>  ">

						</div>



					</div>
				</form>
				<div id="tabla-contentt">


				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-finalizar" class="btn btn-success" data-dismiss="modal">CERRAR</button>

			</div>
		</div>
	</div>	
</div>

<script src="/Public/js/evaluationperiod.js"></script>