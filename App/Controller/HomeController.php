<?php

namespace App\Controller;

use App\Model\InstitutionModel as Institution;
use App\Config\View as View;
use App\Config\Session as Session;

class HomeController
{
	
	function __construct()
	{
		
	}

	function indexAction(){

		if(Session::check('authenticated')):
			header("Location: /".Session::get('rol'));

		else:
			echo "404";
		endif;
	}
}