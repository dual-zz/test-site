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
   $db = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
   //$db->prepare("SELECT id FROM session");
   $STH = $db->prepare("SELECT `name` FROM `user_info` WHERE id = 1");
   $STH->execute();
   print_r($STH->fetch());
   echo "--------\n";
   
   $loader = new Twig_Loader_String();
   $twig = new Twig_Environment($loader);
    
   $template = $twig->loadTemplate('Привет {{ name }}!');
    
   $template->display(array('name' => 'Миша'));
   
   echo "\n--------\n";
   
   echo $_SESSION['qqq']['www'];
   $_SESSION['qqq']['www'] = '=***';
   echo $_SESSION['qqq']['www'];
      print_r($_SESSION['qqq']);
   echo "--------\n";
   $que = $db->query("SELECT * FROM `user_info`");
   echo $que->rowCount();
   
   SQL_Error($db);
   
   while ($row = $que->fetch())
   {
      print_r($row);
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

print_r($mass);

$_SESSION['nya'] = $mass;
print_r($_SESSION['nya']);
echo $mass['login'] . $mass['pass'] . '/n' . $_SESSION['nya']['id'];



?>