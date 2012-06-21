<?php
session_start();
?>
<pre>
<?php

require_once '/Twig/Autoloader.php';

Twig_Autoloader::register();

require './class/database/config.php';
$mass;
$STH = new PDOStatement;
try
{
   $db = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,eval(PDO_UTF));
   //$db->prepare("SELECT id FROM session");
   $STH = $db->prepare("SELECT * FROM `user_info` WHERE id = 1");
   $STH->execute();
   SQL_Error($STH);
   
   while ($row = $STH->fetch())
   {
      print_r($row);
      
      if (isset($row['rights']))
      {
          echo "string";
      }
      if ($row['id'] == 50)
      {
          $mass = $row;
      }
      //print_r($row);
   }
}
catch (PDOException $ee)
{
   echo $ee->getMessage();
   echo "root problen";
}


?>