<?php


class Controller_Dashboard extends Controller_Base 
{
	private $registry;

	function __construct($registry) 
	{
		$this->registry = $registry;
	}

	protected function user_panel ()
	{
		$query =	"SELECT 
						name
					FROM 
						users
					WHERE
						id = :id
					";

		$dbst = $this->registry->get('database')->prepare($query);  
		$dbst->bindParam(':id', $_SESSION['id']);

		// Выполняем запрос
		$dbst->execute();

		$result = $dbst->fetchAll(PDO::FETCH_ASSOC);

		return 'Привет, ' . $result[0]['name'] . '! [<a href="/user/logout">Выйти</a>]';
	}

	function index() 
	{
		if(false == $this->is_loged_in())
		{
			header("Location: /");
			die();
		}

		$page_title = 'Приборная панель';
		$page_content = '<p>[Здесь мы добавим инструменты]</p>'; // TODO

		$page_user_panel = $this->user_panel();

		// Настраиваем шаблон
		$this->registry->get('template')->set ('page_title', $page_title);
		$this->registry->get('template')->set ('page_content', $page_content);
		$this->registry->get('template')->set ('page_user_panel', $page_user_panel);

		// Показываем шаблон
		$this->registry->get('template')->show('index');		

	}

}


?>