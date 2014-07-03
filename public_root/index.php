<?php

// Проверяем версию PHP
if (version_compare(phpversion(), '5.3.0', '<') == true) { die ('Use PHP 5.3.0+'); }

define ('DIRSEP', DIRECTORY_SEPARATOR);

// Подключаем класс-загрузчик
require dirname(__FILE__) . DIRSEP . '..' . DIRSEP . 'classes' . DIRSEP . 'class.loader.php';


Loader::run();