<!--

JJRondón
ITI
-->
<?php
$iti = false;

if($baseDatos=='agoranet_itigvc'){
    $iti = true;

}
?>

<table class="table content-table " id="content-inputs">


    <!-- On rows -->
    <thead class="">

    <tr id="background-rows-table"  valign="middle">
        <th >#</th>
        <th >APELLIDOS Y Nombres Estudiante</th>
        <th > <span data-toggle="tooltip" data-placement="top" title="ESTADO"> Est</span></th>
        <th > <span data-toggle="tooltip" data-placement="top" title="NOVEDADES">Nov</span></th>
        <th >O.A.</th>
        <th > <span data-toggle="tooltip" data-placement="top" title="INASISTENCIA">FAA</span></th>
        <?php
        foreach ($porcentajeDefinidos as $key => $value)
        {
            if($value['id_indicadores']==($key+1))
            {
                echo "<th>".$value['abreviacion']." ".$value['porcentaje']."%</th>";
            }
        }
        ?>
        <th >VAL</th>
    </tr>
    </thead>

    <?php
    $cont = 0;
    $num = 1;
    $active = 'active';


    foreach ($datos  as $clave => $row) {

        $estudiante = $row['primer_apellido']." ".$row['segundo_apellido']." ". $row['primer_nombre']." ".$row['segundo_nombre'];
        ?>

        <tr class="<?=$active = $num%2==0?'active':''?> inputs editable" id="<?=$row['id_estudiante']?>" >

            <th>
                <?=$num++;?>
            </th>
            <td>
				<span data-id="<?=$row['id_estudiante']?>">
					<?= $estudiante ?>
				</span>
            </td>

            <td>
                <span data-id="<?=$row['id_estudiante']?>"> <?=$row['estatus']?> </span>
            </td>
            <td>
                <span> <?=$row['novedad']?></span>
            </td>
            <td>
                <button data-student="<?= $estudiante?>" data-id="<?=$row['id_estudiante']?>" data-click="aggObsAsig" data-request="openModal" class="btn btn-primary btn-sm" title="Agregar Observación en la Asignatura">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </button>
            </td>

            <td >
                <input data-id="<?=$row['id_estudiante']?>" name="inasistencia_p<?=$p;?>" data-cont="<?=$cont++;?>" step="1.0"
                       type="number"  class="form-control"   value="<?=$row['inasistencia_p'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="ep" name="dc1_<?=$p;?>"  data-cont="<?=$cont++;?>" step="0.1"
                       type="text" class="form-control " value="<?=$row['dc1_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupoep" name="dc6_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled
                       value="<?=$row['dc6_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="ex" name="dc2_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                       type="text"  class="form-control"    value="<?=$row['dc2_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupoex" name="dc7_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled
                       value="<?=$row['dc7_'.$p]?>">
            </td>

            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="tt" name="dc3_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                       type="text"  class="form-control" placeholder=""
                       value="<?=$row['dc3_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupott" name="dc8_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled
                       value="<?=$row['dc8_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="pz" name="dc4_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                       type="text"  class="form-control"   value="<?=$row['dc4_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupopz" name="dc9_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled
                       value="<?=$row['dc9_'.$p]?>">
            </td>
            <td>
				<?php
					if($iti){
						?>
					<input data-id="<?=$row['id_estudiante']?>" data-desemp="ad" name="aeep_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                       type="text"   class="form-control"   value="<?=$row['aeep_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupoad" name="porcent_aeep_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled   value="<?=$row['porcent_aeep_'.$p]?>">
					<?php
					}
					else{
						
					?>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="ad" name="dc5_<?=$p;?>" data-cont="<?=$cont++;?>" step="0.1"
                       type="text"   class="form-control"   value="<?=$row['dc5_'.$p]?>">
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupoad" name="dc10_<?=$p;?>" data-grupo="lista" type="hidden"
                       step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled   value="<?=$row['dc10_'.$p]?>">
					<?php
						}
				?>
            </td>



            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="periodo" name="eval_<?=$p;?>_per" step="0.1"
                       type="text" class="form-control input-sin-borde" readonly disabled   value="<?=$row['eval_'.$p.'_per']?>">

            </td>

        </tr>


        <?php

    }

    ?>
    <input type="hidden" id="numRegistro" name="" value="<?=$num?>">
    <input type="hidden" id="numInputs" name="" value="<?=$cont;?>">

</table>