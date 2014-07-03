<?php


abstract class Controller_Base 
{
	private $registry;

	function __construct($registry) 
	{
		$this->registry = $registry;
	}

	protected function is_loged_in ()
	{
		// Проверяем аутентифицирован ли пользователь
		if(isset($_SESSION['id']) && null !== $_SESSION['id'])
			return true;
		else
			return false;
	}

	abstract function index();
}


?>