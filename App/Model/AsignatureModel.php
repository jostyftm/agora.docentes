<?php

namespace App\Model;

use App\Config\DataBase as DB;

/**
* 
*/
class AsignatureModel extends DB
{
	private $table = 't_asignaturas';
	
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
	public function getByAreaAndGrade($id_area, $id_grade)
	{
		$this->query = "SELECT DISTINCT ta.id_asignatura, ta.asignatura  
						FROM  t_asignatura_x_area t 
						INNER JOIN t_asignaturas ta  ON t.id_asignatura = ta.id_asignatura  
						WHERE t.id_area={$id_area} and t.id_grado ={$id_grade} ORDER BY ta.asignatura ASC";

		return $this->getResultsFromQuery();
	}
}
?>