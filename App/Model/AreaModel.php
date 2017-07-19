<?php
namespace App\Model;

use App\Config\DataBase as DB;
/**
* 
*/
class AreaModel extends DB
{
	
	function __construct($db='')
	{	
		if(!$db)
			throw new \Exception("La clase ".get_class($this)." no encontro la base de datos", 1);
		else
			parent::__construct($db);
	}

	public function getByGrade($id_grade)
	{
		$this->query = "SELECT DISTINCT a.id_area, a.area
						FROM t_asignatura_x_area t
						INNER JOIN t_area a ON t.id_area = a.id_area  AND t.id_grado = {$id_grade} ORDER BY a.area ASC";

		return $this->getResultsFromQuery();
	}
}
?>