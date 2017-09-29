<!--
Plantilla para:
Simon Nolivar,
Liceo
-->

<?php
$liceo = false;
if($baseDatos=='agoranet_liceo') {
    $liceo = true;
}
?>
<table class="table content-table " id="content-inputs">


    <thead class="">
    <tr id="background-rows-table"  valign="middle">
        <th rowspan="2">#</th>
        <th rowspan="2">APELLIDOS Y Nombres Estudiante</th>
        <th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="ESTADO"> Est</span></th>
        <th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="NOVEDADES">Nov</span></th>
        <th rowspan="2">O.A.</th>
        <th rowspan="2"> <span data-toggle="tooltip" data-placement="top" title="INASISTENCIA">FAA</span></th>

        <th colspan="5"><?=$porcentajes['etiqueta_grupo_1']; ?> <?=$porcentajes['porcentaje_grupo1']; ?>%</th>

        <th rowspan="2" ></th>

        <th colspan="5" ><?php echo ($porcentajes['etiqueta_grupo_2'].($liceo?" Y ".$porcentajes['etiqueta_grupo_3']:""));
            ?> <?=$porcentajes['porcentaje_grupo2']?>%</th>
        <th rowspan="2"></th>

        <th rowspan="2" class="<?=($liceo?"hidden":"")?>">aee</th>
        <th rowspan="2" class="<?=($liceo?"hidden":"")?>">VAEE <?=$porcentajes['porcentaje_autoevaluacion']?>%</th>
        <th rowspan="2">VAL</th>
        <th rowspan="2">..</th>
        <th rowspan="2">..</th>
    </tr>
    <tr id="item-posicion" valign="middle" class="border-th">


        <th data-update="dc1" data-estado="false" data-tipo="1">

        </th>

        <th data-update="dc2" data-estado="false" data-tipo="1">

        </th>
        <th data-update="dc3" data-estado="false" data-tipo="1">

        </th>
        <th data-update="dc4" data-estado="false" data-tipo="1">

        </th>
        <th data-update="dc5" data-estado="false" data-tipo="1">

        </th>
		

        <th data-update="dc6" data-estado="<?=($liceo?"false":"true")?>" data-tipo="2" >
			<?php foreach ($criterios as $key => $value) {if($value['posicion']=='dp1' && !$liceo){echo $value['abreviacion'];}	}?>
		</th>
        <th data-update="dc7" data-estado="<?=($liceo?"false":"true")?>" data-tipo="2">
			<?php foreach ($criterios as $key => $value) {if($value['posicion']=='dp2' && !$liceo){echo $value['abreviacion'];}	}?>
		</th>
        <th data-update="dc8" data-estado="<?=($liceo?"false":"true")?>" data-tipo="2" >
			<?php foreach ($criterios as $key => $value) {if($value['posicion']=='dp3' && !$liceo){echo $value['abreviacion'];}	}?>
		</th>
        <th data-update="dc9" data-estado="<?=($liceo?"false":"true")?>" data-tipo="2">
			<?php foreach ($criterios as $key => $value) {if($value['posicion']=='dp4' && !$liceo){echo $value['abreviacion'];}	}?>
		</th>
        <th data-update="dc10" data-estado="<?=($liceo?"false":"true")?>" data-tipo="2">
			<?php foreach ($criterios as $key => $value) {if($value['posicion']=='dp5' && !$liceo){echo $value['abreviacion'];}	}?>
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
                <button data-student="<?= $estudiante?>" data-id="<?=$row['id_estudiante']?>" data-click="aggObsAsig" data-request="openModal" class="btn btn-primary btn-sm" title="Agregar Observación en la Asignatura">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </button>
            </td>
            <td >
                <input data-id="<?=$row['id_estudiante']?>" name="inasistencia_p<?=$p;?>" data-cont="<?=$cont++;?>"
                       step="1.0"  type="number"  class="form-control"   value="<?=$row['inasistencia_p'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc1_<?=$p;?>"  data-cont="<?=$cont++;?>"
                       step="0.1" type="text" class="form-control " value="<?=$row['dc1_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc2_<?=$p;?>" data-cont="<?=$cont++;?>"
                       step="0.1" type="text"  class="form-control"    value="<?=$row['dc2_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc3_<?=$p;?>" data-cont="<?=$cont++;?>"
                       step="0.1" type="text"  class="form-control" placeholder="" value="<?=$row['dc3_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc4_<?=$p;?>" data-cont="<?=$cont++;?>"
                       step="0.1" type="text"  class="form-control"   value="<?=$row['dc4_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dc" name="dc5_<?=$p;?>" data-cont="<?=$cont++;?>"
                       step="0.1" type="text"  class="form-control"   value="<?=$row['dc5_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupodc" name="pcent_dc_<?=$p;?>" data-grupo="lista"
                       type="number" step="0.1"   type="text"  class="form-control input-sin-borde" readonly disabled
                       value="<?=$row['pcent_dc_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dp" name="<?=$liceo?'dc6_'.$p:'dp1_'.$p?>"
                       data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"
                       value="<?=$liceo?$row['dc6_'.$p]:$row['dp1_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dp" name="<?=$liceo?'dc7_'.$p:'dp2_'.$p?>"
                       data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"
                       value="<?=$liceo?$row['dc7_'.$p]:$row['dp1_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dp" name="<?=$liceo?'dc8_'.$p:'dp3_'.$p?>"
                       data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"
                       value="<?=$liceo?$row['dc8_'.$p]:$row['dp3_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dp" name="<?=$liceo?'dc9_'.$p:'dp4_'.$p?>"
                       data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"
                       value="<?=$liceo?$row['dc9_'.$p]:$row['dp4_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="dp" name="<?=$liceo?'dc10_'.$p:'dp5_'.$p?>"
                       data-cont="<?=$cont++;?>" step="0.1"   type="text"  class="form-control"
                       value="<?=$liceo?$row['dc10_'.$p]:$row['dp5_'.$p]?>">
            </td>
            <td>
                <input data-id="<?=$row['id_estudiante']?>" data-desemp="grupodp"  name="pcent_dp_<?=$p;?>" data-grupo="lista"
                       type="number" class="form-control input-sin-borde" readonly disabled   value="<?=$row['pcent_dp_'.$p]?>">

            </td>

            <td class="<?=($liceo?"hidden":"")?>">
                <?php
                if (!$liceo){ ?>
                    <input data-id="<?=$row['id_estudiante']?>"  data-desemp="da" name="aeep_<?=$p;?>" data-cont="<?=$cont++;?>"
                           step="0.1"   type="text"  class="form-control"  value="<?=$row['aeep_'.$p]?>">
                <?php }
                ?>
            </td>
            <td class="<?=($liceo?"hidden":"")?>">
                <?php
                if (!$liceo){ ?>
                    <input data-id="<?=$row['id_estudiante']?>"  data-desemp="grupoda" data-p="pae" data-grupo="lista"
                           name="porcent_aeep_<?=$p;?>" type="text" class="form-control input-sin-borde" readonly disabled
                           value="<?=$row['porcent_aeep_'.$p]?>">
                <?php }
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
