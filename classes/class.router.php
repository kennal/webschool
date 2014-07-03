<?php


class Router 
{
	private $registry;
	private $path;
	private $args = array();

	function __construct($registry) 
	{
		$this->registry = $registry;
	}

	function setPath($path) 
	{
		$path = DIRSEP . trim($path, '/\\') . DIRSEP;	

		if (false == is_dir($path)) 
		{
			Logger::log ('Неверный путь к контроллерам: `' . $path . '`');
		}
		$this->path = $path;
	}

	private function getController(&$file, &$controller, &$action, &$args) 
	{
		$route = (empty($_GET['route'])) ? '' : $_GET['route'];

		if (empty($route)) 
			$route = 'index';

		// Получаем раздельные части
		$route = trim($route, '/\\');
		$parts = explode('/', $route);

		$cmd_path = $this->path;

		// Находим правильный контроллер
		foreach ($parts as $part) 
		{
			$fullpath = $cmd_path . 'controller.' . $part;

			// Есть ли папка с таким путём?
			if (is_dir($fullpath)) 
			{
				// TODO:
				// Доработать работу с папками
				$cmd_path .= $part . DIRSEP;
				array_shift($parts);
				continue;
			}

			// Находим файл
			if (is_file($fullpath . '.php')) 
			{
				$controller = $part;
				array_shift($parts);
				break;
			}
		}

		if (empty($controller)) 
			$controller = 'index'; 

		$action = array_shift($parts);

		if (empty($action)) 
			$action = 'index';

		$file = $cmd_path . 'controller.' . $controller . '.php';
		$args = $parts;
	}	

	function delegate() 
	{
		// Анализируем путь
		$this->getController($file, $controller, $action, $args);

		// Файл доступен?
		if (false == is_readable($file)) 
		{
			header("Location: /error/error404");
			die ('404 Not Found');
		}

		// Подключаем файл
		require ($file);

		// Создаём экземпляр контроллера
		$class = 'Controller_' . $controller;
		$controller = new $class($this->registry);

		// Действие доступно?
		if (false == is_callable(array($controller, $action))) 
		{
			Logger::log('Action "' . $action . '" is not callable');
			header("Location: /error/error404");
		}

		// Выполняем действие
		$controller->$action();
	}

}


?>