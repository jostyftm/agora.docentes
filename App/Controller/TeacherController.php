<?php

namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\GroupModel as Group;
use App\Model\PeriodModel as Period;
use App\Model\TeacherModel as Teacher;
use App\Model\AsignatureModel as Asignature;
use App\Model\EvaluationPeriodModel as Evaluation;
/**
* 
*/
class TeacherController
{
	
	private $_group;
	private $_teacher;
	private $_periods;
	private $_session;
	private $_asignature;
	private $_evaluation;

	function __construct()
	{	

		if(Session::check('authenticated')):
			$this->_group = new Group(Session::get('db'));
			$this->_periods = new Period(Session::get('db'));
			$this->_teacher = new Teacher(Session::get('db'));	
			$this->_asignature = new Asignature(Session::get('db'));
			$this->_evaluation = new Evaluation(Session::get('db'));
		else:
			header("Location: http://agora.net.co/app_Login/");
		endif;
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function HomeAction($db='', $idTeacher='')
	{

		$asginatures = $this->_teacher->getAsignaturesAndGroups($_SESSION['id_teacher'])['data'];

		$view = new View(
			'teacher',
			'home',
			[
				'asginatures'	=>	$asginatures
			]
		);

		$view->execute();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function indexAction($db='', $idTeacher='')
	{	

		if(Session::check('authenticated')):
			$this->evaluationAction();
			// $teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			// $subheader = array(
			// 'tittle'	=>	'Inicio',
			// 'icon'	=>	'fa fa-home',
			// 	'items'	=>	array()
			// );

			// $view = new View(
			// 	'teacher',
			// 	'index',
			// 	[
			// 		'include'		=>	'partials/home.tpl.php',
			// 		'subheader'		=>	$subheader,
			// 		'institution'	=>	$_SESSION['institution'],
			// 		'teacher'		=>	$teacher
			// 	]
			// );
			// $view->execute();
		endif;
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function evaluationAction()
	{	
		if(Session::check('authenticated')):

			// 
			$groups = $this->_teacher->getAsignaturesAndGroups(
				$_SESSION['id_teacher']
			)['data'];

			// 
			$subgroups = $this->_teacher->getAsignaturesAndSubGroups(
				$_SESSION['id_teacher']
			)['data'];

			$teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			// Creamos el subheader para los menus horizontal
			$subheader = array(
				'tittle'	=>	'Evaluación',
				'icon'	=>	'fa fa-check',
				'items'	=>	array(
					1	=>	array(
						'tittle'	=>	'Evaluar',
						'link'	=>	'/teacher/evaluate',
						'active' =>	'active'
					)
				),
			);

			// Preguntamos si el docente es director de algun grupo
			if($this->_teacher->isDirector($_SESSION['id_teacher']))
			{
				array_push($subheader['items'], array(
					'tittle'	=>	'Observaciones Generales',
					'link'	=>	'/generalObservation/index/teacher',
					'active' =>	''
				));
				array_push($subheader['items'], array(
					'tittle'	=>	'Informe General de Periodo',
					'link'	=>	'/generalReportPeriod/index/teacher',
					'active' =>	''
				));
			}

			$view = new View(
				'teacher',
				'index',
				[
					'tittle_panel'		=>	'',
					'include'			=>	'partials/evaluation/home.tpl.php',
					'subheader'			=>	$subheader,
					'groups'			=>	$groups,
					'subgroups'			=>	$subgroups,
					'institution'		=>	$_SESSION['institution'],
					'teacher'			=>	$teacher
				]
			);

			$view->execute();
		endif;
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function evaluateAction()
	{
		if(Session::check('authenticated')):

			// 
			$groups = $this->_teacher->getAsignaturesAndGroups(
				$_SESSION['id_teacher']
			)['data'];

			// 
			$subgroups = $this->_teacher->getAsignaturesAndSubGroups(
				$_SESSION['id_teacher']
			)['data'];

			$view = new View(
				'teacher/partials/evaluation',
				'home',
				[
					'tittle_panel'		=>	'',
					'groups'			=>	$groups,
					'subgroups'			=>	$subgroups
				]
			);

			$view->execute();

		endif;
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function sheetsAction()
	{	
		if(Session::check('authenticated')):
			$periods = $this->_periods->all()['data'];
			$asignatures = $this->_teacher->getAsignaturesAndGroups($_SESSION['id_teacher'])['data'];

			$teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			$subheader = array(
				'tittle'	=>	'Planillas',
				'icon'	=>	'fa fa-file-text-o',
				'items'	=>	array()
			);
			$view = new View(
				'teacher',
				'index',
				[
					'include'		=>	'partials/sheets/home.tpl.php',
					'tittle_panel'	=>	'Planillas',
					'institution'	=>	$_SESSION['institution'],
					'subheader'		=>	$subheader,
					'asignatures'	=>	$asignatures,
					'periods'		=>	$periods,
					'teacher'		=>	$teacher
				]
			);

			$view->execute();
		endif;
	}


	/**
	 * 
	 * @param
	 * @return
	*/
	public function StatisticsAction($section='')
	{
		if(Session::check('authenticated')):

			$teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			$subheader = array(
				'tittle'	=>	'Estadisticas',
				'icon'	=>	'fa fa-line-chart',
				'items'	=>	array()
			);

			$view = new View(
				'teacher',
				'index',
				[
					'include'		=>	'partials/statistic/index.tpl.php',
					'institution'	=>	$_SESSION['institution'],
					'subheader'		=>	$subheader,
					'teacher'		=>	$teacher,
					'url'			=> 	'http://agora.net.co/estadisticas/Estadisticas/setIndex/'.Session::get('db'),
				]
			);
			$view->execute();
			// $teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			// switch ($section) {
			// 	case 'consolidate':
			// 		$this->StatisticsConsolidate($teacher);
			// 		break;
			// 	case 'student':
			// 		$this->StatisticsStudent($teacher);
			// 		break;
			// 	case 'disapproved':
			// 		$this->StatisticsDisapproved($teacher);
			// 		break;
			// 	case 'performanceByTeacher':
			// 		$this->performanceByTeacher($teacher);
			// 		break;
			// }
			
		endif;
	}

	/**
	 * 
	 * @param
	 * @return
	*/
	private function StatisticsConsolidate($teacher)
	{
		// Creamos el subheader para los menus horizontal
		$subheader = array(
			'tittle'	=>	'Estadisticas - Consolidados',
			'icon'	=>	'fa fa-line-chart',
			'items'	=>	array()
		);
		$view = new View(
				'teacher',
				'index',
				[
					'tittle_panel'		=>	'',
					'include'			=>	'partials/statistic/consolidate/consolidate.tpl.php',
					'subheader'			=>	$subheader,
					'institution'	=>	$_SESSION['institution'],
					'teacher'		=>	$teacher
				]
			);

			$view->execute();
	}

	/**
	 * 
	 * @param
	 * @return
	*/
	private function StatisticsStudent($teacher)
	{
		// Creamos el subheader para los menus horizontal
		$subheader = array(
			'tittle'	=>	'Estadisticas - Studiantes',
			'icon'	=>	'fa fa-line-chart',
			'items'	=>	array(
				1	=>	array(
					'tittle'	=>	'Matriculado por sexo',
					'link'		=>	'/statistic/studentSexRegistered',
					'active'	=>	'active'
				),
				2	=>	array(
					'tittle'	=>	'Eficiencia',
					'link'		=>	'/statistic/studentEfficiency',
					'active'	=>	''
				)
			)
		);

		$view = new View(
			'teacher',
			'index',
			[
				'tittle_panel'		=>	'',
				'include'			=>	'partials/statistic/student/studentSexRegistered.tpl.php',
				'subheader'			=>	$subheader,
				'institution'	=>	$_SESSION['institution'],
				'teacher'		=>	$teacher
			]
		);

		$view->execute();
	}

	/**
	 * 
	 * @param
	 * @return
	*/
	private function StatisticsDisapproved($teacher)
	{
		// Creamos el subheader para los menus horizontal
		$subheader = array(
			'tittle'	=>	'Estadisticas - Reprobados',
			'icon'	=>	'fa fa-line-chart',
			'items'	=>	array(
				1	=>	array(
					'tittle'	=>	'Estudianes Reprobados',
					'link'		=>	'/statistic/studentDisapproved',
					'active'	=>	'active'
				),
				2	=>	array(
					'tittle'	=>	'Reprobrados Detallados',
					'link'		=>	'/statistic/detailDisapproved',
					'active'	=>	''
				)
			)
		);

		$view = new View(
			'teacher',
			'index',
			[
				'tittle_panel'		=>	'',
				'include'			=>	'partials/statistic/disapproved/studentDisapproved.tpl.php',
				'subheader'			=>	$subheader,
				'institution'	=>	$_SESSION['institution'],
				'teacher'		=>	$teacher
			]
		);

		$view->execute();
	}

	/**
	*
	*
	*/
	public function performanceByTeacher($teacher)
	{
		// Creamos el subheader para los menus horizontal
		$subheader = array(
			'tittle'	=>	'Estadisticas - Desempeño por Docente',
			'icon'	=>	'fa fa-line-chart',
			'items'	=>	array()
		);

		$view = new View(
			'teacher',
			'index',
			[
				'tittle_panel'		=>	'',
				'include'			=>	'partials/statistic/performance/performanceByTeacher.tpl.php',
				'subheader'			=>	$subheader,
				'institution'	=>	$_SESSION['institution'],
				'teacher'		=>	$teacher
			]
		);

		$view->execute();
	}

	/**
	 * 
	 * @param
	 * @return
	*/
	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function settingsAction()
	{	
		if(Session::check('authenticated')):
			// 
			$teacher = $this->_teacher->find($_SESSION['id_teacher'])['data'][0];

			// Creamos el subheader para los menus horizontal
			$subheader = array(
				'tittle'	=>	'Configuracio',
				'icon'	=>	'fa fa-cog',
				'items'	=>	array(
					1	=>	array(
						'tittle'	=>	'Configuracion de la cuenta',
						'link'	=>	'/settings/index/teacher',
						'active' =>	'active'
					),
					// 2	=>	array(
					// 	'tittle'		=>	'Seguridad e inicio de sesión',
					// 	'link'		=>	'/settings/security/teacher',
					// 	'active'	=>	''
					// )
				),
			);

			$view = new View(
				'teacher',
				'index',
				[
					'tittle_panel'	=>	'',
					'subheader'		=>	$subheader,
					'include'		=>	'partials/settings/account/general.tpl.php',
					'teacher'		=>	$teacher,
					'institution'	=>	$_SESSION['institution'],
				]
			);

			$view->execute();
		endif;
	}

	// /**
	//  *
	//  *	@param
	//  *  @return
	// */ 
	// public function evaluateAction()
	// {	

	// 	$groupsAndAsign = $this->_teacher->getAsignaturesAndGroups($_SESSION['id_teacher'])['data'];

	// 	$view = new View(
	// 		'teacher/partials/evaluation',
	// 		'home',
	// 		[
	// 			'tittle_panel'		=>	'Evaluar Periodo',
	// 			'groupsAndAsign'	=>	$groupsAndAsign
	// 		]
	// 	);

	// 	$view->execute();
	// }


	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function showFormEvaluatePeriodAction($groupType = 'group')
	{
		// Validamos la peticion GET
		if(isset($_GET['options']['request']) && $_GET['options']['request']== 'spa'):
			
			$infoGroup = array();
			$infoAsignature = $this->_asignature->find($_GET['id_asignature'])['data'][0];

			if($groupType == 'group'):
				$infoGroup = $this->_group->find($_GET['id_group'])['data'][0];
			else:
				$infoGroup = $this->_group->findSubGroup($_GET['id_group'])['data'][0];
			endif;

			$view = new View(
				'teacher/partials/evaluation',
				'formEvaluatePeriod',
				[
					'tittle_panel'	=>	'Evaluar periodo pendiente',
					'group'			=> 	$infoGroup,
					'groupType'		=>	$groupType,
					'asignature'	=>	$infoAsignature,
					'back'			=>	$_GET['options']['back']
				]
			);

			$view->execute();

		else:
			echo "404 no se puede mostrar esta pagina";
		endif;
	}


	/**
	 *
	 *
	 *
	*/
	public function performanceByGroup()
	{
		
	} 

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function getStudentWithoutPeriodEvaluationAction(
		$column,
		$id_asignature, 
		$id_group,
		$groupType = 'group'
	){


		$students = $this->_evaluation->getPeriodsWithOutEvaluating(
			$column, $id_asignature, $id_group, $groupType
		)['data'];

		$view = new View(
			'teacher/partials/evaluation',
			'formEvaluatePeriodRender',
			[
				'students'	=> 	$students,
				'groupType'	=>	$groupType,
				'id_group'	=>	$id_group,
				'periodo'	=>	$column
			]
		);

		$view->execute();
	}

	/**
	 *
	 *	@param
	 *  @return
	*/ 
	public function updatePeriodAction(
		$period, 
		$id_student, 
		$id_asignature, 
		$id_group,
		$value,
		$groupType = 'group'
	)
	{
		echo json_encode(
			$this->_evaluation->updatePeriod(
				$period,
				$id_student,
				$id_asignature, 
				$id_group,
				$value,
				$groupType
			)
		);
	}
}
?>