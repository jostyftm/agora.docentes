<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\AreaModel as Area;

/**
* 
*/
class AreaController
{
	private $_area;

	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_area = new Area(Session::get('db'));
		endif;
	}

	/**
	*
	*
	*
	*/
	public function getByGradeAction($id_grade)
	{
		$areas = $this->_area->getByGrade($id_grade);

		if($areas['state']):

			echo '<option value=0>SELECCIONE UN AREA</option>';
			foreach ($areas['data'] as $key => $area) 
				echo '<option value="'.$area['id_area'].'">'.$area['area'].'</option>';
			
		else:
			echo '<option value=0>No hay Resultados</option>';
		endif;
	}
}
?>