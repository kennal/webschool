<?php


class Controller_Error extends Controller_Base 
{
	private $registry;

	function __construct($registry) 
	{
		$this->registry = $registry;
	}

	function error404()
	{

		$error_code = "404";
		$error_description = '<p>Запрашиваемая страница не существует</p>';

		$this->registry->get('template')->set ('error_code', $error_code);
		$this->registry->get('template')->set ('error_description', $error_description);

		$this->registry->get('template')->show('error');
	}

	function index() 
	{
		header("Location: /");
		die();
	}

}


?>