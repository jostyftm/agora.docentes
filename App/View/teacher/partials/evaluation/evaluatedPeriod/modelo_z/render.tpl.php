<!--  -->


<div class="col-md-12 ">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table content-table table_evaluated" id="content-inputs">
					<!-- On rows -->
					<thead class="">
						<tr id="background-rows-table"  valign="middle">
							<th rowspan="2">#</th>
							<th rowspan="2">APELLIDOS Y Nombres Estudiante</th>
							<th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="ESTADO"> Est</span></th>
							<th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="NOVEDADES">Nov</span></th>
							<th rowspan="2">O.A.</th>
							<th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="INASISTENCIA">FAA</span></th>

							<th colspan="7"><?php echo $porcentajes['etiqueta_grupo_1'] ?> </th>
							<th rowspan="2">VAL</th>

						</tr>
						<tr id="item-posicion" valign="middle" class="border-th">


							<th data-update="dc1" data-estado="false" data-tipo="1">
								<?php //foreach ($codigos  as  $row) 	{ echo $row['posicion']=='dc1'?$row["cod_desemp"]:'';}?>				
							</th>

							<th data-update="dc2" data-estado="false" data-tipo="1">

							</th>
							<th data-update="dc3" data-estado="false" data-tipo="1">

							</th>
							<th data-update="dc4" data-estado="false" data-tipo="1">

							</th>
							<th data-update="dc5" data-estado="false" data-tipo="1">

							</th>
                            <th data-update="dc6" data-estado="false" data-tipo="1">

                            </th>
                            <th data-update="dc7" data-estado="false" data-tipo="1">

                            </th>


						</tr>


					</thead>

					<?php
					$cont = 0;
					$num = 1;
					$active = 'active';


					foreach ($datos  as $clave => $row) {


						?>

						<tr class="<?=$active = $num%2==0?'active':''?> inputs editable" id="<?=$row['id_estudiante']?>" >

							<th>
								<?=$num++;?>
							</th>
							<td>
								<span data-id="<?=$row['id_estudiante']?>">

									<?= $row['primer_apellido']." ".$row['segundo_apellido']." ". $row['primer_nombre']." ".$row['segundo_nombre']?>


								</span>  
							</td>

							<td>
								<span data-id="<?=$row['id_estudiante']?>"> <?=$row['estatus']?> </span>
							</td>
							<td>
								<span> <?=$row['novedad']?></span>
							</td>
							<td>
								<i data-id="<?=$row['id_estudiante']?>" class="fa fa-user" aria-hidden="true"></i>
							</td>

							<td >
								<input data-id="<?=$row['id_estudiante']?>"
                                       name="inasistencia_p<?=$p;?>" data-cont="<?=$cont++;?>"
                                       step="1.0"  type="text"  class="form-control"   value="<?=$row['inasistencia_p'.$p]?>">
							</td>       
							<td>
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc1_<?=$p;?>"  data-cont="<?=$cont++;?>" step="0.1" type="text" class="form-control " value="<?=$row['dc1_'.$p]?>">
							</td>
							<td>
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc2_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"    value="<?=$row['dc2_'.$p]?>">
							</td>

							<td>              
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc3_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control" placeholder=""
								value="<?=$row['dc3_'.$p]?>">

							</td>
							<td>
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc4_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"   value="<?=$row['dc4_'.$p]?>">
							</td>
							<td>
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc5_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"   type="text"   class="form-control"   value="<?=$row['dc5_'.$p]?>">
							</td>
                            <td>
                                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc"
                                       name="dc6_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                                       type="text"   class="form-control"   value="<?=$row['dc6_'.$p]?>">
                            </td>
                            <td>
                                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc"
                                       name="dc7_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                                       type="text"   class="form-control"   value="<?=$row['dc7_'.$p]?>">
                            </td>
							<td class="hidden">

								<input data-id="<?=$row['id_estudiante']?>" data-desemp="grupodc" name="pcent_dc_<?=$p;?>" data-grupo="lista" type="number" step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled   value="<?=$row['pcent_dc_'.$p]?>">


							</td>
							<td>
								<input data-id="<?=$row['id_estudiante']?>" data-desemp="periodo" name="eval_<?=$p;?>_per" step="0.1" type="text" class="form-control input-sin-borde" readonly disabled   value="<?=$row['eval_'.$p.'_per']?>">

							</td>

							<!-- <td>..</td>
							<td>..</td> -->

						</tr>


						<?php

					}

					?>
					<input type="hidden" id="numRegistro" name="" value="<?=$num?>">
					<input type="hidden" id="numInputs" name="" value="<?=$cont;?>">
				</table>
			</div>
		</div>
	</div>
</div>