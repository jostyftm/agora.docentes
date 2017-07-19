<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\AsignatureModel as Asignature;

/**
* 
*/
class AsignatureController
{
	
	private $_asignature;

	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_asignature = new Asignature(Session::get('db'));
		endif;
	}

	/**
	*
	*
	*/
	public function getByAreaAndGradeAction($id_area, $id_grade)
	{
		$asignatures = $this->_asignature->getByAreaAndGrade($id_area, $id_grade);

		if($asignatures['state']):
			foreach ($asignatures['data'] as $key => $asignautre)
				echo '<option value="'.$asignautre['id_asignatura'].'">'.$asignautre['asignatura'].'</option>';	
		else:
			echo '<option value=0>No hay Resultados</option>';
		endif;
	}
}
?>