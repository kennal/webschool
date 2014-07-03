<?php


class Logger
{
	public static function log ($message)
	{
		// Записываем ошибку в сандартный лог-файл
		error_log ('[' . trim ($message) . '] ', 0);
	}
}

?>