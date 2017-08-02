<?php

namespace App\Model;

use App\Config\DataBase as DB;
use App\Model\ValorationModel as Valoration;
/**
* 
*/
class EvaluationPeriodModel extends DB
{
	protected $table = 't_evaluacion';
	protected $table_recovery = 'superacion';
	
	private $_periods = array();

	// 
	private $_valoration;
	
	function __construct($db='')
	{
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else{
			parent::__construct($db);
			$this->_valoration = new Valoration($db);
		}
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
		$this->query = "SELECT e.id_estudiante, e.primer_apellido AS alu_primer_ape, e.segundo_apellido AS alu_segundo_ape, e.primer_nombre AS alu_primer_nom, e.segundo_nombre AS alu_segundo_nom, d.primer_apellido AS dir_primer_ape, d.segundo_apellido AS dir_segundo_ape, d.primer_nombre AS dir_primer_nom, d.segundo_apellido AS dir_segundo_nom, g.id_grupo, g.nombre_grupo, a.id_asignatura, a.asignatura, e.novedad, e.estatus";

		for ($i=0; $i < $maxPeriod; $i++) { 
			$this->query .= ", e.eval_".($i+1)."_per periodo".($i+1)." ";
		}

		$this->query .= " FROM t_evaluacion e
						INNER JOIN t_grupos g ON e.id_grupo=g.id_grupo AND g.id_grupo={$id_group}
						INNER JOIN t_asignaturas a ON e.id_asignatura=a.id_asignatura AND a.id_asignatura={$id_asignature}
						INNER JOIN docentes d ON g.id_director_grupo=d.id_docente
						ORDER BY e.primer_apellido, e.segundo_apellido";

		return $this->getResultsFromQuery();
	}

	public function getEvaluation($id_group, $id_asignature){
			$this->query = "SELECT * 
							FROM t_evaluacion 
							WHERE id_grupo = '{$id_group}' AND id_asignatura = '{$id_asignature}'
							ORDER BY primer_apellido";

			return $this->getResultsFromQuery();
	}
	
	public function getEvaluationByDiscipline($id_group){
        $this->query = "SELECT id_estudiante, eval_1_per, eval_2_per, eval_3_per, eval_4_per 
							FROM t_evaluacion 
							WHERE id_grupo = '{$id_group}' AND id_asignatura = 9
							ORDER BY primer_apellido";

        return $this->getResultsFromQuery();
    }

	public function queryChangeColumns($data){

        $this->query = "ALTER TABLE t_evaluacion CHANGE '{data[0][columnOld]}'  '{data[0][columnNew]}' '{data[0][type]}'";
        $this->execute_single_query();
    }
	
	/**
	*
	*
	*/
	public function getGroupRecovery($period, $id_group, $id_asignature){

		$this->query = "SELECT ev.eval_{$period}_per AS periodo,  s.idstudents, s.primer_apellido AS primer_ape_alu, s.segundo_apellido AS segundo_ape_alu, s.primer_nombre AS primer_nom_alu, s.segundo_nombre AS segundo_nom_alu, a.asignatura, g.nombre_grupo
						FROM t_evaluacion ev
						INNER JOIN students s ON ev.id_estudiante=s.idstudents
						INNER JOIN t_grupos g ON ev.id_grupo = g.id_grupo AND g.id_grupo = {$id_group}
						INNER JOIN t_asignaturas a ON ev.id_asignatura=a.id_asignatura AND a.id_asignatura = {$id_asignature}
						WHERE ev.eval_{$period}_per < 
						(
						    SELECT v.minimo
						    FROM valoracion v
						    WHERE v.valoracion='Basico'
						) ";

		return $this->getResultsFromQuery();
	}


	/**
	*
	*
	*/
	public function checkQualification($qualification){

		$valorations = $this->_valoration->all();

		if(!$valorations['state'])
			throw new \Exception("No hay Valoracion para calificar", 1);
		else{

			foreach ($valorations['data'] as $key => $valoration) {
				
				if($qualification >= $valoration['minimo'] && $qualification <= $valoration['maximo'])
					return true;
			}

			return false;
		}
	}

	/**
	*
	*
	*/
	public function getRecovery($id_student, $id_group, $id_asignature, $period){

		$this->query = "SELECT * 
						FROM {$this->table_recovery} 
						WHERE id_estudiante={$id_student}  AND id_asignatura={$id_asignature} AND id_grupo={$id_group}";

		return $this->getResultsFromQuery();
	}

	/**
	*
	*
	*/
	public function saveRecovery($data=array()){

		$resp = array();

		if($this->checkQualification($data['newContent'])):

			$this->query = "INSERT INTO {$this->table_recovery} 
							(id_estudiante, id_asignatura, id_grupo, periodo, nota, nota_evaluacion)
							VALUES
							({$data['id_student']}, {$data['id_asignature']}, {$data['id_group']}, {$data['period']}, {$data['newContent']}, {$data['oldContent']})";
			$rows = $this->executeQuerySingle();

			array_push($resp, $rows);

			if($rows['data']):
				// ($field,$id_student, $id_asignature, $value)
				$data = $this->updatePeriod(
					"eval_{$data['period']}_per",
					$data['id_student'],
					$data['id_asignature'],
					$data['newContent']
				);

				array_push($resp, $data);
			endif;


			return array(
				'state'		=>	true,
				'mensaje' 	=>	$resp
			);

		else:

			return array(
				'state'		=> 	false,
				'mensaje'	=>	'Rango excedido'
			);
		endif;
	}


	/**
	*
	*
	*/
	public function updateRecovery($id_recovery, $data=array()){

		$response = array();
		if($this->checkQualification($data['newContent'])):

			$this->query = "UPDATE {$this->table_recovery} 
							SET nota={$data['newContent']}, nota_evaluacion={$data['oldContent']} 
							WHERE id_superacion={$id_recovery} ";

			$rows = $this->executeQuerySingle();

			array_push($response, $rows);

			if($rows['data']):
				$data = $this->updatePeriod(
					"eval_{$data['period']}_per",
					$data['id_student'],
					$data['id_asignature'],
					$data['newContent']
				);

			array_push($response, $data);
			endif;

			return array(
				'state'	=>	true,
				'data'	=>	$response
			);

		else:

			return array(
				'state'		=> 	false,
				'mensaje'	=>	'Rango excedido'
			);

		endif;
	}
}
?>