<?php

namespace App\Model;

use App\Config\DataBase as DB;

/**
* 
*/
class EvaluationPeriodModel extends DB
{
	protected $table = 't_evaluacion';

	private $_periods = array();


	function __construct($db='')
	{
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else
			parent::__construct($db);
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function getPeriodsWithOutEvaluating($column, $id_asignature, $id_group){
		$this->query = "SELECT e.$column AS periodo, s.idstudents, s.primer_apellido AS primer_ape_alu, s.segundo_apellido AS segundo_ape_alu, s.primer_nombre AS primer_nom_alu, s.segundo_nombre AS segundo_nom_alu, a.id_asignatura, a.asignatura, g.nombre_grupo, g.id_grupo 
						FROM {$this->table} e
						INNER JOIN students s ON e.id_estudiante=s.idstudents
						INNER JOIN t_grupos g ON g.id_grupo={$id_group} AND e.id_grupo=g.id_grupo 
						INNER JOIN t_asignaturas a ON a.id_asignatura={$id_asignature} AND e.id_asignatura=a.id_asignatura 
						WHERE e.$column IS NULL OR e.$column = 0 
						ORDER BY e.primer_apellido";

		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function updatePeriod($field,$id_student, $id_asignature, $value){
			$this->query = "UPDATE {$this->table}
							SET {$field}={$value}
							WHERE id_estudiante={$id_student} AND id_asignatura={$id_asignature}";

			// return ['query'=>$this->query];
			return $this->executeQuerySingle();
	}

	/**
	 *
	 * @param
	 * @return
	 */
	public function getPeriods($maxPeriod, $id_asignature, $id_group)
	{
		$this->query = "SELECT e.primer_apellido AS alu_primer_ape, e.segundo_apellido AS alu_segundo_ape, e.primer_nombre AS alu_primer_nom, e.segundo_nombre AS alu_segundo_nom, d.primer_apellido AS dir_primer_ape, d.segundo_apellido AS dir_segundo_ape, d.primer_nombre AS dir_primer_nom, d.segundo_apellido AS dir_segundo_nom, g.id_grupo, g.nombre_grupo, a.id_asignatura, a.asignatura, e.novedad, e.estatus";

		for ($i=0; $i < $maxPeriod; $i++) { 
			$this->query .= ", e.eval_".($i+1)."_per periodo".($i+1)." ";
		}

		$this->query .= " FROM t_evaluacion e
						INNER JOIN t_grupos g ON e.id_grupo=g.id_grupo AND g.id_grupo={$id_group}
						INNER JOIN t_asignaturas a ON e.id_asignatura=a.id_asignatura AND a.id_asignatura={$id_asignature}
						INNER JOIN docentes d ON g.id_director_grupo=d.id_docente
						ORDER BY e.primer_apellido";

		return $this->getResultsFromQuery();
	}

	public function getEvaluation($id_group, $id_asignature){
			$this->query = "SELECT * 
							FROM t_evaluacion 
							WHERE id_grupo = '{$id_group}' AND id_asignatura = '{$id_asignature}'
							ORDER BY primer_apellido";

			return $this->getResultsFromQuery();
	}
}
?>