<?php
namespace App\Model;

use App\Config\DataBase as DB;
/**
* 
*/
class FinalReportModel extends DB
{
	
	function __construct($db='')
	{	
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else
			parent::__construct($db);
	}

	public function find($id_student, $id_group, $id_asignature)
	{
		$this->query = "SELECT ifg.id_informe, ifg.id_estudiante, ifg.id_grupo, ifa.id_asignatura, ifa.valoracion, s.primer_apellido AS primer_ape_alu, 
s.segundo_apellido AS segundo_ape_alu, s.primer_nombre AS primer_nom_alu, s.segundo_nombre AS segundo_nom_alu 
				FROM informe_final_general ifg 
				INNER JOIN informe_final_asignaturas ifa ON ifg.id_informe=ifa.id_informe
				INNER JOIN students s ON ifg.id_estudiante = s.idstudents 
				WHERE ifg.id_grupo={$id_group} AND ifa.id_asignatura={$id_asignature} AND ifg.id_estudiante={$id_student}";

		return $this->getResultsFromQuery();
	}

	public function update(
		$id_IF,
		$id_asignature,
		$value
	)
	{	

		$this->query = "UPDATE informe_final_asignaturas
						SET valoracion={$value}
						WHERE id_informe={$id_IF} AND id_asignatura={$id_asignature}";

		return $this->executeQuerySingle();
	}
}
?>