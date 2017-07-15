<?php
namespace App\Controller;
use App\Config\Session as Session;

use App\Model\GroupModel as Group;
/**
* 
*/
class GroupController
{
	
	private $_group;

	function __construct()
	{
		if(Session::check('authenticated')):
			$this->_group = new Group(Session::get('db'));
		endif;
	}

	public function indexAction()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function create()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function store()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function show()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function edit()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function update()
	{

	}

	/**
	 *
	 * @param
	 * @return
	 *
	*/
	public function delete()
	{

	}
	
	/*
	 *
	*/
	public function getClassRoomOptionsAction($id_group)
	{
		// $group = new Group(DB);

		$classRoom = $this->_group->getClassRoomList($id_group)['data'];

		foreach ($classRoom as $key => $student) {
			echo "<option value='".$student['idstudents']."'>".
					utf8_encode(
						$student['primer_ape_alu']." ".
						$student['segundo_ape_alu']." ".
						$student['primer_nom_alu']." ".
						$student['segundo_nom_alu']
					)
				."</option>";
		}
	}
}
?>