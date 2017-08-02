<?php

namespace App\Model;

use App\Config\DataBase as DB;

/**
* 
*/
class AsignatureModel extends DB
{
	private $table = 't_asignaturas';
	private $table_observation = 'observacion_asignatura';

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
	public function find($id_asignature)
	{
		$this->query = "SELECT * FROM {$this->table} WHERE id_asignatura='{$id_asignature}'";
		return $this->getResultsFromQuery();
	}

	/**
	 *
	 * @param
	 * @return
	*/
	public function all()
	{
		$this->query = "SELECT * FROM {$this->table}";
		return $this->getResultsFromQuery();
	}

	/**
	*
	*
	*
	*/
	public function getObservationByStudent($id_student, $id_asignature, $period)
	{
		$this->query = "SELECT *
						FROM {$this->table_observation}
						WHERE id_estudiante={$id_student} AND id_asignatura={$id_asignature} AND periodo={$period}";

		return $this->getResultsFromQuery();
	}

	/**
	*
	*
	*/
	public function finObservation($id_observation)
	{
		$this->query = "SELECT *
						FROM {$this->table_observation}
						WHERE id={$id_observation}";

		return $this->getResultsFromQuery();
	}

	/**
	*
	*
	*/
	public function saveObservation($data=array())
	{
		$this->query = "INSERT INTO {$this->table_observation}
						(id_asignatura, id_estudiante, periodo, observacion)
						VALUES
						({$data['id_asignature']}, {$data['id_student']}, {$data['period']}, '{$data["observation"]}')";

		return $this->executeQuerySingle();
	}

	/**
	*
	*
	*/
	public function updaeObservation($id_observation, $observation)
	{
		$this->query = "UPDATE {$this->table_observation}
						SET observacion='{$observation}'
						WHERE id={$id_observation}";

		return $this->executeQuerySingle();
	}


	/**
	*
	*
	*/
	public function deleteObservation($id_observation)
	{
		$this->query = "DELETE FROM {$this->table_observation}
						WHERE id={$id_observation}";

		return $this->executeQuerySingle();
	}


	/**
	*
	*
	*
	*/
	public function getByAreaAndGrade($id_area, $id_grade)
	{
		$this->query = "SELECT DISTINCT ta.id_asignatura, ta.asignatura  
						FROM  t_asignatura_x_area t 
						INNER JOIN t_asignaturas ta  ON t.id_asignatura = ta.id_asignatura  
						WHERE t.id_area={$id_area} and t.id_grado ={$id_grade} ORDER BY ta.asignatura ASC";

		return $this->getResultsFromQuery();
	}

	public function getTypeAsignature($id_asignature, $id_grado)
    {
        $this->table = "t_asignatura_x_area";
        $this->query = "SELECT tipo_asig FROM {$this->table} WHERE id_asignatura='{$id_asignature}' and id_grado='{$id_grado}' ";
        return $this->getResultsFromQuery();
    }
}
?>