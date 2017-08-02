<?php
namespace App\Controller;
use App\Config\View as View;
use App\Model\GroupModel as Group;
use App\config\Session as Session;
use App\Model\GradeModel as Grade;
use App\Model\PeriodModel as Period;
use App\Model\TeacherModel as Teacher;
use App\Model\AsignatureModel as Asignature;
use App\Model\ValorationModel as Valoration;
use App\Model\PerformanceModel	as Performance;
use App\Model\EvaluationPeriodModel as Evaluation;
/**
* 
*/
class EvaluationController
{
	// Declaramos los objetos a utilizar
	private $_group;
	private $_grade;
	private $_period;
	private $_teacher;
	private $_evaluation;
	private $_valoration;
	private $_performance;
	private $_asignature;

	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_grade = new Grade(Session::get('db'));
			$this->_group = new Group(Session::get('db'));
			$this->_period = new Period(Session::get('db'));
			$this->_teacher = new Teacher(Session::get('db'));
			$this->_evaluation = new Evaluation(Session::get('db'));
			$this->_valoration = new Valoration(Session::get('db'));
			$this->_asignature = new Asignature(Session::get('db'));
			$this->_performance = new Performance(Session::get('db'));
		else:
			echo "404";
		endif;
	}

	public function evaluateGroupAction($id_asignature, $id_group)
	{	
		//obtenerPorcentajesDefinidos
		$porcentajeDefinidos = $this->_performance->getIndicators(); 

		$expresiones = $this->_performance->getExpression(); //obtenerExpresiones

		// obtenerDatos	
		$datosTitulos = $this->_group->groupAndAsign($id_asignature, $id_group);

        $id_grade = $this->_group->getGradeByGroup($id_group)['data'][0]['id_grado'];
		$type_asignature = $this->_asignature->getTypeAsignature($id_asignature,$id_grade)['data'][0]['tipo_asig'];


		if($datosTitulos['state']):

			$id_grado = $datosTitulos['data'][0]['id_grado'];
			$valoraciones = $this->_valoration->all()['data'];
			$result_porcentajes = $this->_performance->getPercentage()['data'];	

			$grados = $this->_grade->all()['data'];
			$periodos = $this->_period->all()['data'];
			$asignaturas = $this->_asignature->all()['data'];
			$criterios = $this->_performance->getCriterions()['data'];
			$categorias = $this->_performance->allCategories()['data'];

            if($id_grade <= 4 || $type_asignature == "C")
                $result_porcentajes[0]['porcentaje_grupo1']=100;

			$view = new View(
				'teacher/partials/evaluation/evaluatedPeriod', 
				'home', 
				[
					'grupo'=>$id_group, 
					'grados' => $grados, 
					'periodos' => $periodos, 
					'titulos' =>$datosTitulos['data'][0], 
					'valoracion'=>$valoraciones,  
					'categorias' => $categorias, 
                    'criterios'    => $criterios,
                    'expresiones' => $expresiones['data'][0],
					'asignatura'=>$id_asignature, 
					'asignaturas' => $asignaturas, 
					'database' => Session::get('db'),
					'porcentajes' => $result_porcentajes[0] , 
					'grado' => $id_grado, 
                    'porcentajeDefinidos' => $porcentajeDefinidos			
				]
			);
			$view->execute();
		endif;
	}

	/**
	*
	*
	*
	*/
	public function evaluateGroupRenderAction($period, $id_asignature, $id_group)
	{

		$resultado = $this->_evaluation->getEvaluation($id_group, $id_asignature);


		if($resultado['state']):

			$result_porcentajes = $this->_performance->getPercentage()['data'];
			$criterios = $this->_performance->getCriterions()['data'];
			$codigos = $this->_performance->getCodes($id_group, $id_asignature, $period)['data'];
			$id_grade = $this->_group->getGradeByGroup($id_group)['data'][0]['id_grado'];
			$type_asignature = $this->_asignature->getTypeAsignature($id_asignature,$id_grade)['data'][0]['tipo_asig'];

			$modelo ='';
			if(Session::get('db') == 'agoranet_ieag')
				$modelo = 'modelo_a';
			
			else if(Session::get('db') == 'agoranet_ipec' || Session::get('db') == 'agoranet_cabal'
                || Session::get('db') == 'agoranet_jrbejarano' || Session::get('db') == 'agoranet_iensjl' )
				$modelo = 'modelo_b';
			
			else if(Session::get('db') == 'agoranet_iean' )
				$modelo = 'modelo_c';				
			
			else if(Session::get('db') == 'agoranet_simonb' ||Session::get('db') == 'agoranet_liceo' )
				$modelo = 'modelo_d';				
			
            else if(Session::get('db') == 'agoranet_termarit' || Session::get('db') == 'agoranet_iesr' || Session::get('db') == 'agoranet_litoral'
				   || Session::get('db') == 'agoranet_comfamar')
            	$modelo = 'modelo_e';

            else if(Session::get('db') == 'agoranet_jjrondon' || Session::get('db') == 'agoranet_itigvc')
            	$modelo = 'modelo_f';

            if($id_grade <= 4 || $type_asignature == "C")
                $modelo = 'modelo_z';

            $view = new View(
            	'teacher/partials/evaluation/evaluatedPeriod/'.$modelo,
            	'render',
				[
					'codigos' => $codigos, 
                    'p'        =>$period,
					'criterios' =>$criterios,
					'datos'=>$resultado['data'], 
					'id_asignature'	=> $id_asignature,
					'baseDatos' => Session::get('db'),
					'porcentajes' => $result_porcentajes[0]
				]
			);
			$view->execute();


		endif;
	}

	/**
	*
	*
	*
	*/
	public function updateAllAction()
	{
		if(!empty($_POST) && isset($_POST['idEstudiante'])):

			$resp = array();

			foreach ($_POST['obj'] as $key => $value):
				array_push(
					$resp,
					$this->_evaluation->updatePeriod(
						$key, 
						$_POST['idEstudiante'],
						$_POST['asignaturaDB'],
						$value
					)
				);
			endforeach;

			echo json_encode($resp);

		endif;
	}

	/**
	*
	*
	*
	*/
	public function groupRecoveryAction($id_asignature, $id_group){

		$group = $this->_group->find($id_group)['data'][0];
		$asignature = $this->_asignature->find($id_asignature)['data'][0];

		$view = new View(
            'teacher/partials/evaluation/recovery',
            'groupRecovery',
			[
				'tittle_panel'	=>	'Superaciones',
				'asignature'	=>	$asignature,
				'group'			=>	$group,
				'periods'		=>	$this->_period->all()['data'],
				'back'			=>	$_GET['options']['back']
			]
		);
		$view->execute();
	}

	/**
	*
	*
	*
	*/
	public function getGroupRecoveryRenderAction($period, $id_group, $id_asignature)
	{
		$resp = $this->_evaluation->getGroupRecovery($period,$id_group, $id_asignature );

		$view = new View(
            'teacher/partials/evaluation/recovery',
            'groupRecoveryRender',
			[
				'students'		=>	$resp['data'],
				'period'		=>	$period,
				'id_group'		=>	$id_group,
				'id_asignature'	=>	$id_asignature,
				'period'		=>	$period,
				'periods'		=>	$this->_period->all()['data']
			]
		);
		$view->execute();
	}

	/**
	*
	*
	*
	*/
	public function updateGroupRecoveryAction()
	{
		

		if(!empty($_POST) && count($_POST) == 6):
			
			$recovery = $this->_evaluation->getRecovery(
				$_POST['id_student'],
				$_POST['id_group'],
				$_POST['id_asignature'],
				$_POST['period']
			);

			if($recovery['state']):
				
				sleep(3);
				echo json_encode(
					$this->_evaluation->updateRecovery(
						$recovery['data'][0]['id_superacion'],
						$_POST
					)
				);

			else:

				sleep(3);
				echo json_encode(
					$this->_evaluation->saveRecovery($_POST)
				);

			endif;
		endif;
	}
}
?>