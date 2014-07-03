<?php


class Template 
{
	private $registry;
	private $vars = array();

	function __construct($registry) 
	{
			$this->registry = $registry;
	}

	function set($varname, $value, $overwrite = false) 
	{
		if (true == isset($this->vars[$varname]) AND false == $overwrite) 
			return false;

		$this->vars[$varname] = $value;
		return true;
	}

	function remove($varname) 
	{
		unset($this->vars[$varname]);
		return true;
	}

	function show($name) 
	{
		$path = site_path . templates_dir . DIRSEP . $name . '.php';

		if (false == file_exists($path)) 
		{
			Logger::log("Template file does not exists");
			header("Location: /error/500");
			die();			
		}

		// Перечисляем переменные для подстановки в шаблон
		foreach ($this->vars as $key => $value) 
			$$key = $value;

		define('run_micritime', microtime(true) - stat_microtime);

		require ($path);
	}
}


?>