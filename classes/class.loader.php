<?php


class Loader 
{
	private $vars = array();

	public static function setup()
	{
		// Общие настройки
		define ('site_path',		realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP);
		define ('templates_dir',	'templates');
		define ('controllers_dir',	'controllers');
		define ('classes_dir',		'classes');
		define ('stat_microtime',	microtime(true));

		// Подключаем файл с настройками доступа к базе данных
		require site_path . 'config.php';

		// Название сайта
		// TODO: по идее, лучше хранить и брать из базы данных
		define ('site_title', 'Web-студия');

		// Запускаем сессию
		session_start();

		// Настраиваем автоподгрузку запрашиваемых классов
		function __autoload($class_name) 
		{
			if(0 === strpos ($class_name, "Controller")) 
			{
				$dir = controllers_dir;
				$prefix = 'controller';
			}
			else 
			{
				$dir = classes_dir;
				$prefix = 'class';
			}

			$file = site_path . $dir . DIRSEP . $prefix . '.' . strtolower($class_name) . '.php';

			if (false == file_exists($file)) 
				return false;

			require ($file);
		}
	}

	public static function run() 
	{
		self::setup();

		// Создаем объект регистра
		$registry = new Registry;

		// Создаём объект для доступа к базе данных
		$connect_args = 
			'pgsql:' 	. 
			'host='		. db_host . ';' . 
			'port=' 	. db_port . ';' .
			'dbname='	. db_dbname . ';' .
			'user='		. db_user . ';' .
			'password='	. db_password; 

		$database = new PDO($connect_args);
		$registry->set ('database', $database);

		// Создаем объект шаблона
		$template = new Template($registry);
		$registry->set ('template', $template);

		// Создаем объект роутера 
		$router = new Router($registry);
		$registry->set ('router', $router);
		$router->setPath (site_path . 'controllers');
		$router->delegate ();

	}
}


?>