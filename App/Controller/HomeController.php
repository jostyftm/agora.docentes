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
			header("Location: http://agora.net.co/app_Login/");
		endif;
	}
}