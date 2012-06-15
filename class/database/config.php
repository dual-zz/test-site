<?php
define('PDO_CONNECT_HOST','mysql:host=localhost;dbname=register;');//charset=utf8;');
define('PDO_CONNECT_USER', 'root');
define('PDO_CONNECT_PASS', '');
$PDO_UTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`');

define('GET_NAME', 1);
 

function SQL_Error($DBH)
{
	$error_array = $DBH->errorInfo();
 
   if ($DBH->errorCode() != 00000)
   {
      die("SQL ошибка: " . $error_array[2] . '<br /><br />');
   }
}

?>