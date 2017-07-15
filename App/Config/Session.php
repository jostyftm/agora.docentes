<?php
namespace App\Config;

/**
* 
*/
class Session
{
	
		
	public function __construct()
	{
		
	}

	/**
	* @params
	*
	* @return
	*/
	public static function init(){
		session_start();
	}

	/**
	* @params
	*
	* @return
	*/
	public static function set($key, $value){
		$_SESSION[$key] = $value;
	}

	/**
	* @params
	*
	* @return
	*/
	public static function get($key){
		return $_SESSION[$key];
	}

	/**
	* @params
	*
	* @return
	*/
	public static function getStatus(){
		return session_status();
	}

	/**
	* @params
	*
	* @return
	*/
	public static function check($key){
		
		if(self::getStatus() != 2)
			self::init();

		if(isset($_SESSION[$key])) 
			return true;

		return false;
	}

	/**
	* @params
	*
	* @return
	*/
	public static function destroy(){
		session_destroy();
	}
}
?>