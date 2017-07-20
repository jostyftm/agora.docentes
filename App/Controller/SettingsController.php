<?php
namespace App\Controller;

use App\Config\View as View;
use App\Config\Session as Session;
use App\Model\TeacherModel as Teacher;
/**
* 
*/
class SettingsController 
{
	private $_teacher;
	private $_institution;
	
	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_teacher = new Teacher(Session::get('db'));

		else:
			echo "404";
		endif;
	}

	/**
	*
	*
	*
	*/
	public function updateInfoAction()
	{	
		// 
		if(!empty($_POST) && isset($_POST['request'])):

			if($_POST['role'] == 'teacher'):
				
				$response = array();

				foreach ($_POST['data'] as $field => $value):
					array_push(
						$response,
						$this->_teacher->update(
							$_POST['id_teacher'],
							$field,
							$value
						)
					);
				endforeach;
				
				if($response[0]['state']):
					// echo json_encode($response);

					$info = $this->_teacher->find($_POST['id_teacher'])['data'];

					$view = new View(
						'/teacher/partials/settings/account',
						'general',
						[
							'teacher'	=>	$info[0]
						]
					);
					$view->execute();
				endif;
			endif;

		endif;
		
	}

	/**
	*
	*
	*/
	public function checkPasswordAction()
	{
		// 
		if(!empty($_POST) && isset($_POST['request'])):

			if($_POST['role'] == 'teacher'):
				sleep(3);
				echo json_encode(
						$this->_teacher->checkPassword(
							$_POST['documento'],
							$_POST['password']
						)
					);
			endif;

		endif;
	}

	/**
	*
	*
	*
	*/
	public function updatePasswordAction()
	{
		// 
		if(!empty($_POST) && isset($_POST['request'])):

			if($_POST['role'] == 'teacher'):

				sleep(3);
				$response = $this->_teacher->updatePassword(
					$_POST['documento'],
					$_POST['newPassword']
				);
				if($response['state']):

					$info = $this->_teacher->find($_POST['id_teacher'])['data'];

					$view = new View(
						'/teacher/partials/settings/account',
						'general',
						[
							'teacher'	=>	$info[0]
						]
					);
					$view->execute();
				endif;
			endif;

		endif;
	}


	/**
	*
	*
	*
	*/
	public function indexAction($role)
	{
		if($role == 'teacher'):

			$info = $this->_teacher->find(Session::get('id_teacher'))['data'][0];

			$view = new View(
				'/teacher/partials/settings/account',
				'general',
				[
					'teacher'	=>	$info
				]
			);

			$view->execute();

		elseif($role == 'institution'):

		endif;
	}

	public function securityAction($role)
	{
		if($role == 'teacher'):

			$info = $this->_teacher->find(Session::get('id_teacher'));
			$view = new View(
				'/teacher/partials/settings/account',
				'security',
				[
					'teacher'	=>	$info
				]
			);

			$view->execute();

		elseif($role == 'institution'):

		endif;
	}
}
?>