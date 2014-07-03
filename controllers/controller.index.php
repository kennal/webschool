<?php


class Controller_Index extends Controller_Base 
{
	private $registry;

	function __construct ($registry) 
	{
		$this->registry = $registry;
	}

	function index () 
	{
		if(true == $this->is_loged_in())
		{
			header("Location: /dashboard");
			die();
		}

		$page_title = "Форма аутентификации";

		$page_content = 
		'
			<form method="post" action="/user/login" id="login_form" name="login_form">
				<input name="act" value="login" type="hidden">
				<p>E-mail:<br/><input name="email" class="input" maxlength="100" type="text"></p>  
				<p>Пароль:<br/><input name="password" class="input" maxlength="100" type="password"></p> 
				<p><input value="Отправить" name="button" class="button" type="submit"> </p>
			</form>
		';

		$this->registry->get('template')->set ('page_title', $page_title);
		$this->registry->get('template')->set ('page_content', $page_content);
		$this->registry->get('template')->show('index');
	}

}


?>