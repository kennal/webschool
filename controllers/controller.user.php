<?php


class Controller_User extends Controller_Base 
{
	private $registry;

	function __construct($registry) 
	{
		$this->registry = $registry;
	}

	function index() 
	{
		header("Location: /");
		die();
	}

	function login() 
	{
		$errors = array();

		if (0 === strlen($_POST['email']) or 0 === strlen($_POST['password']))
		{
			header("Location: /");
			die();
		}

		// "Email address validation" - http://squiloople.com/2009/12/20/email-address-validation/
		$email_regexp_rule = '/^(?!(?>"?(?>\\\[ -~]|[^"])"?){255,})(?!"?(?>\\\[ -~]|[^"]){65,}"?@)(?>([!#-\'*+\/-9=?^-~-]+)(?>\.(?1))*|"(?>[ !#-\[\]-~]|\\\[ -~])*")@(?!.*[^.]{64,})(?>([a-z\d](?>[a-z\d-]*[a-z\d])?)(?>\.(?2)){0,126}|\[(?:(?>IPv6:(?>([a-f\d]{1,4})(?>:(?3)){7}|(?!(?:.*[a-f\d][:\]]){8,})((?3)(?>:(?3)){0,6})?::(?4)?))|(?>(?>IPv6:(?>(?3)(?>:(?3)){5}:|(?!(?:.*[a-f\d]:){6,})(?5)?::(?>((?3)(?>:(?3)){0,4}):)?))?(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)(?>\.(?6)){3}))\])$/iD';

		if (preg_match ($email_regexp_rule, $_POST['email'] = trim ($_POST['email'])))
			$email = $_POST['email'];
		else
			$errors['email'] = "Введён неверный электронный адрес";

		// максимальная длинна пароля
		$password_max_len = 64;	

		if (preg_match ("/.+/i", $_POST['password']) and $password_max_len >= strlen ($_POST['password']))
			$password = md5($_POST['password']);
		else 
			$errors['password'] = "Введён неверный пароль";

		if (0 === count($errors))
		{
			$query =	"SELECT 
							users.id						, 
							users_registration.is_confirmed	,
							users.email						, 
							users.password
						FROM 
							users 
						INNER JOIN 
							users_registration 
								ON 
									users.id = users_registration.id 
						WHERE 
							users.email = :email
							AND
							users.password = :password
						";

			$dbst = $this->registry->get('database')->prepare($query);  

			$dbst->bindParam(':email', $email);
			$dbst->bindParam(':password', $password);

			// Выполняем запрос
			$dbst->execute();

			$result = $dbst->fetchAll(PDO::FETCH_ASSOC);

			$page_title = 'Аутентификация';

			if($email === $result[0]['email'] && $password === $result[0][password])
			{
				if(true === $result[0]['is_confirmed'])
				{
					$_SESSION['id'] = $result[0]['id'];
					header("Location: /");
					die();
 				}
				elseif (true !== $result[0]['is_confirmed'])
				{
					$page_content .= "<p>Аккаунт не активирован. Провертье почту.</p>";
					$page_content .= '<p>Перейти к <a href="/">форме входа</p>';
				}
			}
			else
			{
				$page_content .= "<p>Неверная пара логин/пароль.</p>";
				$page_content .= '<p>Перейти к <a href="/">форме входа</p>';
			}
		}
		else
		{
			$page_title = 'Ошибка';
			$page_content = '<ul><li>'. implode("</li><li>", $errors) . '</li></ul>';
			// TODO
		}


		// Настраиваем шаблон
		$this->registry->get('template')->set ('page_title', $page_title);
		$this->registry->get('template')->set ('page_content', $page_content);

		// Показываем шаблон
		$this->registry->get('template')->show('index');
	}

	function logout() 
	{
		unset($_SESSION['id']);
		header("Location: /");
	}

	function restore()
	{
		// TODO:
		// Реализовать механизм восстановления пароля
	}

	function register()
	{
		// TODO
		// Реализовать регистрацию
	}


}

?>