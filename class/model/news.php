<?php

define('PDO_CONNECT_HOST','mysql:host=localhost;dbname=register;');//charset=utf8;');
define('PDO_CONNECT_USER', 'root');
define('PDO_CONNECT_PASS', '');
$driver = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`'); 


/**
 * News model
 */
class news_mod {
   
   function __construct()
   {
      ;
   }
   
   public function auth_check()
   {
      session_name('lowlogin');
   
      if (isset($_REQUEST[session_name()]))
      {
         echo "1";
         session_start();
         return 1;
      }
      else if (isset($_COOKIE['highlogin']))    // проверка на hight_login
      {
         echo "2";
         try
         {
            $db = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PO_CONNECT_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`'));
            
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            //throw new Exception($e->getMessage());
         }

         require_once('./php/config.php');
         
         //$db = new PDO('mysql:host=localhost;dbname=register', 'root', '');
         
         if (dbInit())
         {
            $userHash = md5($_SERVER['HTTP_USER_AGENT'] . $_COOKIE['highlogin']);
            
            $dbHash = mysql_query('SELECT id FROM session WHERE hash = \''.mysql_real_escape_string($userHash).'\'');
            
            if (mysql_num_rows($dbHash) == 1)
            {
               session_start();
               
               $row = mysql_fetch_array($dbHash);
               $_SESSION['id'] = $row['id'];
               
               return 1;
            }
            else
            {
               setcookie('highlogin', "", time() - (60 * 60 * 24 * 100), '/'); // удаляем
               
               return 0;
            }
         }
      }

      return 0;
   }
}


?>