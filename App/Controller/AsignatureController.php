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
	
	/**
	*
	*
	*/
	public function indexObservationsAction($id_student, $id_asignature, $period)
	{

		$view = new View(
			'teacher/partials/evaluation/evaluatedPeriod/asignatureObservations',
			'home',
			[
				'id_student'	=>	$id_student,
				'id_asignature'	=>	$id_asignature,
				'period'		=>	$period
			]
		);
		$view->execute();
	}

	/**
	*
	*
	*/
	public function createObservationAction($id_student, $id_asignature, $period){

		$resp = $this->_asignature->getObservationByStudent(
			$id_student, 
			$id_asignature,
			$period
		);


		$view = new View(
			'teacher/partials/evaluation/evaluatedPeriod/asignatureObservations',
			'create',
			[
				'id_student'	=>	$id_student,
				'id_asignature'	=>	$id_asignature,
				'period'		=>	$period,
				'observation'	=>	(isset($resp['data'][0])) ? $resp['data'][0] : ''
			]
		);
		$view->execute();
	}


	/**
	*
	*
	*/
	public function storeObservationsAction()
	{	
		
		if(!empty($_POST)):

			$response = $this->_asignature->getObservationByStudent(
				$_POST['id_student'], 
				$_POST['id_asignature'],
				$_POST['period']
			);

			if($response['state']):

				echo json_encode(
					$this->_asignature->updaeObservation(
						$response['data'][0]['id'],
						$_POST['observation']
					)
				);
			else:
				echo json_encode($this->_asignature->saveObservation($_POST));
			endif;
		endif;
	}

	/**
	*
	*
	*/
	public function editObservationAction($id_observation)
	{
		$observation = $this->_asignature->finObservation($id_observation)['data'][0];

		$view = new View(
			$_GET['rol'].'/partials/evaluation/evaluatedPeriod/asignatureObservations',
			'edit',
			[
				'observation'	=>	$observation
			]
		);
		$view->execute();
	}

	/**
	*
	*
	*/
	public function updateObservationAction()
	{
		if(!empty($_POST)):

			echo json_encode(
				$this->_asignature->updaeObservation(
					$_POST['id_observation'],
					$_POST['observation']
				)
			);

		endif;
	}

	/**
	*
	*
	*/
	public function deleteObservationAction()
	{

		if(!empty($_POST)):

			echo json_encode(
				$this->_asignature->deleteObservation($_POST['id_observation'])
			);

		endif;
	}

	/**
	*
	*
	*/
	public function getObservationByStudentJSONAction($id_student, $id_asignature, $period){

		// sleep(5);
		$resp = $this->_asignature->getObservationByStudent(
					$id_student, 
					$id_asignature,
					$period
				);

		echo json_encode($resp);
	}
}
?>