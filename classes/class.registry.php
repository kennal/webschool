<?php


class Registry 
{
	private $vars = array();

	function set($key, $var) 
	{
		if (isset($this->vars[$key]) == true) 
		{
			Logger::log ('Невозможно назначить перемменную `' . $key . '` - уже назначена.');
		}

		$this->vars[$key] = $var;
		return true;
	}

	function get($key) 
	{
		if (isset($this->vars[$key]) == false) 
		{
				return null;
		}
		return $this->vars[$key];
	}

	function remove($var) 
	{
		unset($this->vars[$key]);
	}
	
}


?>