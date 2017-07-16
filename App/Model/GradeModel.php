<?php
namespace App\Model;

use App\Config\DataBase as DB;
/**
* 
*/
class GradeModel extends DB
{
	
	private $table = 't_grados';
	
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
	public function all()
	{
		$this->query = "SELECT * FROM {$this->table}";
		return $this->getResultsFromQuery();
	}
	
}
?>