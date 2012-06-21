<?php
define('PDO_CONNECT_HOST','mysql:host=localhost;dbname=register;');//charset=utf8;');
define('PDO_CONNECT_USER', 'root');
define('PDO_CONNECT_PASS', '');
$PDO_UTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`');
define('PDO_UTF', 'return ' . var_export($PDO_UTF8, 1) . ';');

define('GET_NAME', 1);
 

function SQL_Error($STH)
{
   if ($STH->errorCode() != 00000)
   {
      $error_array = $STH->errorInfo();
      throw new siteException("SQL ошибка: " . $error_array[2] . '<br /><br />');
   }
}

?>