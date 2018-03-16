<?php
namespace App\Controller;
use App\Config\View as View;
use App\Model\GroupModel as Group;
use App\Config\Session as Session;
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
	private $_asignature;
	private $_performance;

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

	public function evaluateGroupAction(
		$id_asignature, 
		$id_group, 
		$groupType = 'group'
	)
	{	
		//obtenerPorcentajesDefinidos
		$porcentajeDefinidos = $this->_performance->getIndicators(); 

		$expresiones = $this->_performance->getExpression(); //obtenerExpresiones

		// obtenerDatos	
		$datosTitulos = $this->_group->groupAndAsign(
			$id_asignature, $id_group, $groupType
		);

        $id_grade = $datosTitulos['data'][0]['id_grado'];

		$type_asignature = $this->_asignature->getTypeAsignature($id_asignature,$id_grade)['data'][0]['tipo_asig'];


		if($datosTitulos['state']):

			$id_grado = $datosTitulos['data'][0]['id_grado'];
			$valoraciones = $this->_valoration->all()['data'];
			$result_porcentajes = $this->_performance->getPercentage()['data'];	

			$id_area = $this->_asignature->getIdAreaByIdAsignatura($id_asignature, $id_grade)['data'];

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
					'groupType'=>$groupType,
					'grados' => $grados, 
					'periodos' => $periodos, 
					'titulos' =>$datosTitulos['data'][0], 
					'valoracion'=>$valoraciones,  
					'categorias' => $categorias, 
                    'criterios'    => $criterios,
                    'expresiones' => $expresiones['data'][0],
					'asignatura'=>$id_asignature, 
					'asignaturas' => $asignaturas, 
					'porcentajes' => $result_porcentajes[0] , 
					'grado' => $id_grado, 
                    'porcentajeDefinidos' => $porcentajeDefinidos['data'],
                    'id_area' => $id_area	
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
	public function evaluateGroupRenderAction(
		$period, 
		$id_asignature, 
		$id_group,
		$groupType = 'group'
	)
	{	
		$porcentajeDefinidos = $this->_performance->getIndicators(); 

		$resultado = $this->_evaluation->getEvaluation(
			$id_group, 
			$id_asignature,
			$groupType
		);

		$disciplina = $this->_evaluation->getEvaluationByDiscipline(
			$id_group,
			$groupType
		);


		if($resultado['state']):

			$result_porcentajes = $this->_performance->getPercentage()['data'];
			
			$criterios = $this->_performance->getCriterions()['data'];
			
			$codigos = $this->_performance->getCodes(
				$id_group, $id_asignature, $period, $groupType
			)['data'];

			$id_grade = $this->_group->getGradeByGroup(
				$id_group, $groupType
			)['data'][0]['id_grado'];

			$type_asignature = $this->_asignature->getTypeAsignature(
				$id_asignature,$id_grade
			)['data'][0]['tipo_asig'];

			$modelo ='';
			if(Session::get('db') == 'agoranet_ieag')
				$modelo = 'modelo_a';
			
			else if(Session::get('db') == 'agoranet_ipec' || Session::get('db') == 'agoranet_cabal'
                || Session::get('db') == 'agoranet_jrbejarano' || Session::get('db') == 'agoranet_iensjl' 
				|| Session::get('db') == 'agoranet_diocesano' || Session::get('db') == 'agoranet_comfamar')
				$modelo = 'modelo_b';
			
			else if(Session::get('db') == 'agoranet_iean' || Session::get('db') == 'agoranet_itimp' )
				$modelo = 'modelo_c';				
			
			else if(Session::get('db') == 'agoranet_simonb' ||Session::get('db') == 'agoranet_liceo' )
				$modelo = 'modelo_d';				
			
            else if(Session::get('db') == 'agoranet_termarit' || Session::get('db') == 'agoranet_iesr'
					|| Session::get('db') == 'agoranet_esther_ea' || Session::get('db') == 'agoranet_litoral'
                	|| Session::get('db') == 'agoranet_jose_ag'   || Session::get('db') == 'agoranet_jmcordoba'
                	|| Session::get('db') == 'agoranet_lavictoria' || Session::get('db') == 'agoranet_anunciacion'
				   )
            	$modelo = 'modelo_e';

            else if(Session::get('db') == 'agoranet_jjrondon' || Session::get('db') == 'agoranet_itigvc')
            	$modelo = 'modelo_f';

            if($id_grade <= 4 || $type_asignature == "C")
                $modelo = 'modelo_z';
			
            $view = new View(
            	'teacher/partials/evaluation/evaluatedPeriod/'.$modelo,
            	'render',
				[
					'datos'=>$resultado['data'], 
					'groupType'	=>	$groupType,
					'porcentajes' => $result_porcentajes[0], 
					'codigos' => $codigos, 
					'baseDatos' => Session::get('db'),
					'criterios' =>$criterios,
                    'p'        =>$period,
					'disciplina'    => $disciplina['data'],
					'porcentajeDefinidos' => $porcentajeDefinidos['data']
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
						$_POST['grupoDB'],
						$value,
						$_POST['groupType']
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
	public function groupRecoveryAction($id_asignature, $id_group, $type='group'){

		$group = ($type == 'group') ? $this->_group->find($id_group)['data'][0]
				: $this->_group->findSubGroup($id_group)['data'][0];

		$asignature = $this->_asignature->find($id_asignature)['data'][0];

		
		$view = new View(
            'teacher/partials/evaluation/recovery',
            'groupRecovery',
			[
				'tittle_panel'	=>	'Superaciones',
				'asignature'	=>	$asignature,
				'type'			=>	$type,
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
	public function getGroupRecoveryRenderAction(
		$period, 
		$id_group, 
		$id_asignature,
		$type= 'group'
	)
	{   
		$resp = array();
		$respRecovery = array();

		if($period == 'if'):
			$resp = $this->_evaluation->getGroupRecoveryIF(
				$id_group, $id_asignature, $type
			)['data'];

		else:
			$resp = $this->_evaluation->getGroupRecovery(
				$period, $id_group, $id_asignature, $type
			)['data'];

			$respRecovery = $this->_evaluation->findRecoveryByGroup(
				$id_group, $type
			)['data'];
		endif;

		$view = new View(
            'teacher/partials/evaluation/recovery',
            'groupRecoveryRender',
			[
				'students'		=>	$resp,
				'type'			=>	$type,
				'period'		=>	$period,
				'id_group'		=>	$id_group,
				'groupRecovery'	=>	$respRecovery,
				'id_asignature'	=>	$id_asignature,
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
		
		$next = false;
		$blocked = array(
			'agoranet_anunciacion' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			), 
			'agoranet_cabal' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			), 
			'agoranet_comfamar' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_diocesano' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_esther_ea' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_ieag' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_iean' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_iensjl' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => true,
			),
			'agoranet_iesr' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_ipec' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_itigvc' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_itimp' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_jjrondon' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_jmcordoba' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_jose_ag' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_jrbejarano' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_lavictoria' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_liceo' => array(
				'period_enable' => '',
				'period_if' => true,
			),
			'agoranet_litoral' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_patricio_oa' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_simonb' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
			'agoranet_termarit' => array(
				'period_enable' => '1,2,3,4',
				'period_if' => false,
			),
		);

		foreach($blocked as $key => $value):
			if($key == Session::get('db')):
				if($_POST['period'] == 'if'):
					if($value['period_if']):
						print_r($this->changeGroupIFAction($_POST));
					else:
						echo json_encode(
							[
								'state'	=>	false,
								'mensaje'=>	'El modulo de superacion esta desabilitado',
							]
						);
					endif;
				else:
					if(strstr($value['period_enable'], $_POST['period'])):
						$this->changeGroupRecoveryAction($_POST);
					else:
						echo json_encode(
							[
								'state'	=>	false,
								'mensaje'=>	'El modulo de superacion esta desabilitado',
							]
						);
					endif;
				endif;
			endif;
		endforeach;
	}

	public function changeGroupIFAction($data = array())
	{
		$if = $this->_evaluation->getIF(
			$data['id_student'],
			$data['id_group'],
			$data['id_asignature'],
			$data['typeGroup']
		);

		if(!$if['state']):
			echo json_encode($this->_evaluation->saveIF($data, $data['typeGroup']));
		else:
			echo json_encode($this->_evaluation->updateIF(
				$if['data'][0]['id'], $data
			));
		endif;
	}

	public function changeGroupRecoveryAction($data=array())
	{
		if(!empty($data) && count($data) == 7):
				
			$recovery = $this->_evaluation->getRecovery(
				$data['id_student'],
				$data['id_group'],
				$data['id_asignature'],
				$data['period'],
				$data['typeGroup']
			);

			if($recovery['state']):
				
				echo json_encode(
					$this->_evaluation->updateRecovery(
						$recovery['data'][0]['id_superacion'],
						$data
					)
				);

			else:

				echo json_encode(
					$this->_evaluation->saveRecovery($data, $data['typeGroup'])
				);
				
			endif;
		endif;	
	}

    // REFUERZO ACADEMICO

	public function updateGroupReforceAction()
	{	
		if(Session::get('db') != 'agoranet_liceo'):
			if(!empty($data) && count($data) == 7):
					
				$recovery = $this->_evaluation->getReforce(
					$data['id_student'],
					$data['id_group'],
					$data['id_asignature'],
					$data['period'],
					$data['typeGroup']
				);

				if($recovery['state']):
					
					echo json_encode(
						$this->_evaluation->updateReforce(
							$recovery['data'][0]['id'],
							$data
						)
					);

				else:

					echo json_encode(
						$this->_evaluation->saveReforce($data, $data['typeGroup'])
					);
					
				endif;
			endif;
		else:
			echo json_encode(
				[
					'state'	=>	false,
					'mensaje'=>	'El modulo de refuerzo esta desabilitado',
				]
			);
		endif;
	}

    public function getGroupReforceAction($id_asignature, $id_group, $type='group')
    {
    	$group = ($type == 'group') ? $this->_group->find($id_group)['data'][0]
				: $this->_group->findSubGroup($id_group)['data'][0];

		$asignature = $this->_asignature->find($id_asignature)['data'][0];

		
		$view = new View(
            'teacher/partials/evaluation/reforce',
            'groupRefoce',
			[
				'tittle_panel'	=>	'Refuerzo Academico',
				'asignature'	=>	$asignature,
				'type'			=>	$type,
				'group'			=>	$group,
				'periods'		=>	$this->_period->all()['data'],
				'back'			=>	$_GET['options']['back']
			]
		);
		$view->execute();
    }

    public function getGroupReforceRenderAction(
    	$period, 
		$id_group, 
		$id_asignature,
		$type= 'group')
    {
    	$resp = $this->_evaluation->getGroupReforce(
			$period,
			$id_group, 
			$id_asignature,
			$type
		)['data'];

		$respRecovery = $this->_evaluation->findReforceByGroup(
			$id_group, $period, $type
		)['data'];

		$view = new View(
            'teacher/partials/evaluation/reforce',
            'groupReforceRender',
			[
				'students'		=>	$resp,
				'type'			=>	$type,
				'period'		=>	$period,
				'period'		=>	$period,
				'id_group'		=>	$id_group,
				'respRecovery'	=>	$respRecovery,
				'id_asignature'	=>	$id_asignature,
				'periods'		=>	$this->_period->all()['data']
			]
		);
		$view->execute();
    }

}
?>