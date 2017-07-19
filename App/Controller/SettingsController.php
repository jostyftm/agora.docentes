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

	public function indexAction($role)
	{
		if($role == 'teacher'):

			$info = $this->_teacher->find(Session::get('id_teacher'))['data'][0];

			$view = new View(
				'/teacher/partials/settings/account',
				'general',
				[
					'info'	=>	$info
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
					'info'	=>	$info
				]
			);

			$view->execute();

		elseif($role == 'institution'):

		endif;
	}
}
?>