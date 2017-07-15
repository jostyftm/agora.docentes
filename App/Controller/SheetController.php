<?php
namespace App\Controller;

use App\Model\SheetModel as Sheet;
use App\Model\TeacherModel as Teacher;
use App\Model\PerformanceModel as Performance;
use App\Model\InstitutionModel as Institution;
use App\Model\EvaluationPeriodModel as Evaluation;
/**
* 
*/
class SheetController
{
	private $_sheet;
	private $_teacher;
	private $_evaluation;
	private $_institution;
	private $_performance;
	
	/**
	*
	*
	*/
	function __construct()
	{
		$this->_sheet = new Sheet(DB);
		$this->_performance = new Performance(DB);
		$this->_evaluation = new Evaluation(DB);
		$this->_institution = new Institution(DB);
		$this->_teacher = new Teacher(DB);
	}

	/**
	* @author
	* @param
	* @return
	*/
	public function attendanceAction()
	{
		// Preguntamos si el array POST NO esta vacio
		if(!empty($_POST) && isset($_POST['groups'])):

			$path = './'.time().'/';

			$this->_sheet->setPath($path);

			if(!file_exists($path))
				mkdir($path);

			foreach($_POST['groups'] as $key => $group):
				
				$id_asignature = split('-', $group)[0];
				$id_group = split('-', $group)[1];

				$this->_sheet->studentAttendanceSheet($id_asignature, $id_group, 'studentAttendance');
			endforeach;

			// 
			$this->_sheet->merge('l');
		else:

			echo "Vacio";
		endif;
	}

	/**
	*
	*
	*/
	public function evaluationAction()
	{
		if(!empty($_POST) && isset($_POST['groups'])):

			// Creamos el directorio
			$path = './'.time().'/';

			if(!file_exists($path))
			{	
				mkdir($path);
			}

			// OBtenemos los parametros de evaluacion
			$Resp_eP = $this->_performance->getEvaluationParameters()['data'];
			// 
			$evaluation_parameters = array();
			
			// Recorremos cada parametro de evaluacion y creamos un nuevo array
			foreach ($Resp_eP as $key => $value) 
			{
				array_push($evaluation_parameters, 
					array(
						'id_parametro' => $value['id_parametro_evaluacion'],
						'parametro' => $value['parametro'],
						'indicadores' => $this->_performance->getPerformanceIndicators($value['id_parametro_evaluacion'])['data']
					)
				);
			}

			// Cargamos las opciones para el pdf
			$options = array(
				'infoIns'			=> $this->_institution->getInfo()['data'][0],
				'e_parameters'		=>	$evaluation_parameters,
				'orientation'		=>	$_POST['orientation'],
				'papper'			=>	$_POST['papper']
			);

			// Asignamos el directorio
			$this->_sheet->setPath($path);
			// Asignamos las opciones
			$this->_sheet->setOptions($options);

			// Recorremos los grupos y las asignaturas recibidos por POST
			foreach ($_POST['groups'] as $key => $group) {
				
				$id_asignature = split('-', $group)[0];
				$id_group = split('-', $group)[1];

				$this->_sheet->evaluactionSheet($_POST['period'], $id_asignature, $id_group);
			}

			// 
			$this->_sheet->merge($_POST['orientation']);
		else:

		endif;
	}
}
?>