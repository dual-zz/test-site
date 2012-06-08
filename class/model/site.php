<?php
/**
 * General functions of site
 *
 * @package Site
 * @author  SergeShaw@gmail.com
 */

class site extends Exception {
   
   /**
    * Autorization check
    *
    * @return int
    */
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
            throw new Exception($e->getMessage());
         }
      }

      return 0;
   }

   /**
    * Cookies check
    *
    * @return int
    */
   public function cookcheck()
   {
      if (!isset($_COOKIE['cookcheck']) || isset($_GET['cook']))
      {
         if (!isset($_GET['cook']))
         {
            setcookie("cookcheck",  "1",  time() + (60 * 60 * 24 * 365 * 3),  "/");
            header("Location: ".$_SERVER[PHP_SELF]."?cook");
         }
         else if (!isset($_COOKIE['cookcheck']))
         {
             return 0;
         }
         header("Location: ./".substr($_SERVER[PHP_SELF], 0,-4));
      }
      
      return 1;
   }
   
} // END

?>