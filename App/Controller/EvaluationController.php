<?php
namespace App\Controller;
use App\Config\View as View;
use App\Model\GradeModel as Grade;
use App\config\Session as Session;
use App\Model\PeriodModel as Period;
use App\Model\TeacherModel as Teacher;
use App\Model\AsignatureModel as Asignature;
use App\Model\ValorationModel as Valoration;
use App\Model\PerformanceModel	as Performance;
use App\Model\EvaluationPeriodModel as Evaluation;
use App\Model\GroupModel as Group;
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


		if($datosTitulos['state']):

			$id_grado = $datosTitulos['data'][0]['id_grado'];
			$valoraciones = $this->_valoration->all()['data'];
			$result_porcentajes = $this->_performance->getPercentage()['data'];	

			$grados = $this->_grade->all()['data'];
			$periodos = $this->_period->all()['data'];
			$asignaturas = $this->_asignature->all()['data'];
			$criterios = $this->_performance->getCriterions()['data'];
			$categorias = $this->_performance->allCategories()['data'];

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
                    'expresiones' => $expresiones,
					'asignatura'=>$id_asignature, 
					'asignaturas' => $asignaturas, 
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

			$modelo ='';
			if(Session::get('db') == 'agoranet_ieag')
				$modelo = 'modelo_a';
			
			else if(Session::get('db') == 'agoranet_ipec' || Session::get('db') == 'agoranet_cabal' || Session::get('db') == 'agoranet_jrbejarano' )
				$modelo = 'modelo_b';
			
			else if(Session::get('db') == 'agoranet_iean')
				$modelo = 'modelo_c';				
			
			else if(Session::get('db') == 'agoranet_simonb' ||Session::get('db') == 'agoranet_liceo' )
				$modelo = 'modelo_d';				
			
            else if(Session::get('db') == 'agoranet_termarit'  )
            	$modelo = 'modelo_e';
            

            else if(Session::get('db') == 'agoranet_jjrondon' || Session::get('db') == 'agoranet_itigvc')
            	$modelo = 'modelo_f';
            
            $view = new View(
            	'teacher/partials/evaluation/evaluatedPeriod/'.$modelo,
            	'render',
				[
					'datos'=>$resultado['data'], 
					'porcentajes' => $result_porcentajes[0], 
					'codigos' => $codigos, 
					'baseDatos' => Session::get('db'),
					'criterios' =>$criterios
				]
			);
			$view->execute();
		endif;
	}
}
?>