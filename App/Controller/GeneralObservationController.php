<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\PeriodModel as Period;
use App\Model\TeacherModel as Teacher;
use App\Model\GeneralObservationModel as GeneralObservation;
/**
* 
*/
class GeneralObservationController
{	
	private $_generalObservation;
	private $_teacher;
	private $_period;

	function __construct()
	{	
		if(Session::check('authenticated')):
			$this->_generalObservation = new GeneralObservation(Session::get('db'));
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
		// Validanos la Sesion
		if(true):

			// Validamos el rol
			if(isset($role) && $role == 'teacher'):

				$gObservation = $this->_teacher->getGeneralObservations($_SESSION['id_teacher'])['data'];

				$group = $this->_teacher->getGroupByDirector(Session::get('id_teacher'))['data'][0];

				$view = new View(
					'teacher/partials/evaluation/observations',
					'home',
					[
						'tittle_panel'	=>	'',
						'observations'	=>	$gObservation,
						'group'			=>	$group,
						'history'		=>	array(
							'current'	=> '/generalObservation/index/teacher'
						)
					]
				);

				$view->execute();

			endif;
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

			if(isset($_GET['rol']) && $_GET['rol'] == 'teacher'):
				

				$myGroups = $this->_teacher->getGroupByDirector($_SESSION['id_teacher'])['data'];
				$periods = $this->_period->all()['data'];

				$view = new View(
					'teacher/partials/evaluation/observations',
					'create',
					[
						'tittle_panel'	=>	'Agregar Observaciones Generales',
						'myGroups'		=>	$myGroups,
						'periods'		=>	$periods,
						'back'			=>	$_GET['options']['back']
					]
				);

				$view->execute();
			endif;
				
		else:
			echo "404 no se puede mostrar esta pagina";
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

			array_push($response, $this->_generalObservation->save($data));
		endforeach;

		echo json_encode($response);
	}


	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function showAction($id_observation)
	{
	
		$response = $this->_generalObservation->find($id_observation)['data'][0];

		if(isset($_GET['rol']) && $_GET['rol'] == 'teacher'):
			$view = new View(
				'teacher/partials/evaluation/observations',
				'show',
				[
					'tittle_panel'	=>	'Ver Observaciones Generales',
					'observation'		=>	$response,
					'back'			=>	$_GET['options']['back']
				]
			);

			$view->execute();

		elseif(isset($_GET['rol']) && $_GET['rol'] == 'institution'):
			echo "institution";
		else:
			echo "404 no se puede mostrar el contenido";
		endif;
	}


	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function editAction($id_observation)
	{

		$response = $this->_generalObservation->find($id_observation)['data'][0];

		// Validamos el tipo de usuario
		if(isset($_GET['rol']) && $_GET['rol'] == 'teacher'):

			$view = new View(
				'teacher/partials/evaluation/observations',
				'edit',
				[
					'tittle_panel'	=>	'Editar Observaciones Generales',
					'observation'		=>	$response,
					'back'			=>	$_GET['options']['back']
				]
			);

			$view->execute();
		elseif($_GET['rol'] == 'institution'):
			echo "institution";
		else:
			echo "404 no se puede mostrar el contenido";
		endif;
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function updateAction()
	{
		
		$data = array(
			'id_observation'	=>	$_POST['id_observation'],
			'observations'		=>	$_POST['observation']
		);

		echo json_encode($this->_generalObservation->update($data));
	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function deleteAction()
	{
		if($this->_generalObservation->delete($_POST['id_observation'])['state']):
			
			$gObservation = $this->_teacher->getGeneralObservations($_SESSION['id_teacher'])['data'];;

			$group = $this->_teacher->getGroupByDirector(Session::get('id_teacher'))['data'][0];

			$view = new View(
				'teacher/partials/evaluation/observations',
				'home',
				[
					'tittle_panel'	=>	'Observaciones Generales',
					'observations'	=>	$gObservation,
					'group'			=>	$group,
					'history'		=>	array(
						'current'	=> '/generalObservation/index/teacher'
					)
				]
			);

			$view->execute();
		endif;
	}
}

?>