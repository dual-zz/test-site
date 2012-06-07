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
         session_start();
         return 1;
      }
      else if (isset($_COOKIE['highlogin']))    // проверка на hight_login
      {
         try
         {
            $userHash = md5($_SERVER['HTTP_USER_AGENT'] . $_COOKIE['highlogin']);

            $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
            $STH = $DBH->prepare("SELECT id FROM `session` WHERE hash = :userHash");
            $STH->bindValue(':userHash',$userHash);
            $STH->execute();
            SQL_Error($DBH);
            
            if ($STH->rowCount() == 1)
            {
                session_start();
                
                $row = $STH->fetch();
                $_SESSION['id'] = $row['id'];
                
                return 1;
            }
            else
            {
                setcookie('highlogin', "", time() - (60 * 60 * 24 * 100), '/'); // удаляем
                
                return 0;
            }            
         }
         catch(PDOException $e)
         {
            echo $e->getMessage();
            //throw new Exception($e->getMessage());
         }
      }

      return 0;
   }
}


?>