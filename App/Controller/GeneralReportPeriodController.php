<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\PeriodModel as Period;
use App\Model\TeacherModel as Teacher;
use App\Model\GeneralReportPeriodModel as GeneralReportPeriod;

/**
* 
*/
class GeneralReportPeriodController
{
	
	private $_generalReportPeriod;

	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_generalReportPeriod = new GeneralReportPeriod(Session::get('db'));
			$this->_teacher = new Teacher(Session::get('db'));
			$this->_period = new Period(Session::get('db'));
		endif;
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function indexAction($role)
	{

		// Validamos el rol
		if(isset($role) && $role == 'teacher'):

			$reports = $this->_generalReportPeriod->getGeneralReportPeriodByTeacher($_SESSION['id_teacher'])['data'];
			$group = $this->_teacher->getGroupByDirector(Session::get('id_teacher'))['data'][0];

			$view = new View(
				'teacher/partials/evaluation/generalReport',
				'home',
				[
					'tittle_panel'	=>	'Informe General de Periodo',
					'reports'		=>	$reports,
					'group'			=>	$group,
					'history'		=>	array(
						'current'	=> '/GeneralReportPeriod/index/teacher'
					)
				]
			);

			$view->execute();

		endif;
	}

	/**
	 *
	 * @param $role
	 * @return
	 *
	*/
	public function createAction()
	{
		// Validamos la session
		if(true):
			// Validamos la peticion GET
			if(isset($_GET['rol']) && $_GET['rol'] == 'teacher'):

				

				// Pendiende actualizar
				$myGroups = $this->_teacher->getGroupByDirector($_SESSION['id_teacher'])['data'];
				$periods = $this->_period->all()['data'];

				$view = new View(
					'teacher/partials/evaluation/generalReport',
					'create',
					[
						'tittle_panel'		=>	'Crear Informe General de Periodo',
						'myGroups'		=>	$myGroups,
						'periods'		=>	$periods,
						'back'			=>	$_GET['options']['back']
					]
				);

				$view->execute();		
			endif;
		endif;
	}


	/**
	 *
	 * @param role
	 * @return
	 *
	*/
	public function storeAction()
	{	
		$response = array();
		foreach($_POST['students'] as $key => $id):
					
			$data = array(
				'id_student'		=> $id,
				'id_group'			=> $_POST['group'],
				'id_period'			=> $_POST['period'],
				'id_group_director'	=>	$_SESSION['id_teacher'],
				'observations'		=> $_POST['observation']
			);

			array_push($response, $this->_generalReportPeriod->save($data));
		endforeach;

		echo json_encode($response);
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function editAction($id_report)
	{
		// Validamos la Sesion
		if(true):
			$response = $this->_generalReportPeriod->find($id_report)['data'][0];

			// Validamos el tipo de usuario
			if(isset($_GET['rol']) && $_GET['rol'] == 'teacher'):

				$view = new View(
					'teacher/partials/evaluation/generalReport',
					'edit',
					[
						'tittle_panel'	=>	'Editar Informe Generale de Periodo',
						'report'		=>	$response,
						'back'			=>	$_GET['options']['back']
					]
				);

				$view->execute();
			elseif($_GET['rol'] == 'institution'):
				echo "institution";
			else:
				echo "404 no se puede mostrar el contenido";
			endif;
		endif;
	}

	/*
	 *
	 * @param
	 * @return
	 *
	*/
	public function updateAction()
	{
		
		$data = array(
			'id_report'	=>	$_POST['id_report'],
			'observations'		=>	$_POST['observation']
		);

		echo json_encode($this->_generalReportPeriod->update($data));
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function deleteAction()
	{
		if($this->_generalReportPeriod->delete($_POST['id_report'])['state']):
			$reports = $this->_generalReportPeriod->getGeneralReportPeriodByTeacher($_SESSION['id_teacher'])['data'];

				$view = new View(
					'teacher/partials/evaluation/generalReport',
					'home',
					[
						'tittle_panel'	=>	'Informe General de Periodo',
						'reports'	=>	$reports,
						'history'		=>	array(
							'current'	=> '/GeneralReportPeriod/index/teacher'
						)
					]
				);

			$view->execute();
		endif;
	}
}
?>