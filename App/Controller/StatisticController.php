<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;

/**
* 
*/
class StatisticController
{
	
	// Declara objetos a utilizar
	private $_teacher;

	function __construct()
	{
		if(Session::check('autheticated')):
			// Instancear objetos
			$this->_teacher = new Teacher(Session::get('db'));
		endif;
	}


	/**
	 *
	 *
	 *
	*/
	public function consolidateEvaluationAction()
	{
		$view = new View(
			'teacher/partials/statistic/consolidate',
			'consolidate', [
			
			]
		);

		$view->execute();
	}

	/**
	 *
	 *
	 *
	*/
	public function detailDisapprovedAction()
	{
		$view = new View(
			'teacher/partials/statistic/disapproved',
			'detailDisapproved', [
				'tittle_panel' =>	'Reprobados Detallados'
			]
		);

		$view->execute();
	}

	/**
	 *
	 *
	 *
	 *
	*/
	public function performanceByTeacherAction()
	{
		$view = new View(
			'teacher/partials/statistic/performance',
			'performanceByTeacher', [
			
			]
		);

		$view->execute();
	}

	/**
	 *
	 *
	 *
	 *
	*/
	public function studentDisapprovedAction()
	{
		$view = new View(
			'teacher/partials/statistic/disapproved',
			'studentDisapproved', [
				'tittle_panel' =>	'Estudiantes Reprobados'
			]
		);

		$view->execute();
	}

	/**
	 *
	 *
	 *
	 *
	*/
	public function studentEfficiencyAction()
	{
		$view = new View(
			'teacher/partials/statistic/student',
			'studentEfficiency', [
				'tittle_panel' =>	'Eficiencia'
			]
		);

		$view->execute();
	}

	/**
	 *
	 *
	 *
	 *
	*/
	public function studentSexRegisteredAction()
	{
		$view = new View(
			'teacher/partials/statistic/student',
			'studentSexRegistered', [
				'tittle_panel' =>	'Matriculados por Sexo'
			]
		);

		$view->execute();
	}
}
?>