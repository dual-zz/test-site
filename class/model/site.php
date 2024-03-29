<?php
/**
 * General functions of site
 *
 * @package Site
 * @author  SergeShaw@gmail.com
 */


/**
 * Exception class
 */
class siteException extends Exception { }


class Site_Model {
   
   /**
    * Autorization check
    *
    * @return bool
    */
   public function auth_check($auto_cook_chek = TRUE)
   {
      if ($auto_cook_chek == TRUE)
      {
         $this->cookcheck();
      }
      
      session_name('lowlogin');
   
      if (isset($_REQUEST[session_name()]))
      {
         session_start();
         return TRUE;
      }
      else if (isset($_COOKIE['highlogin']))    // проверка на hight_login
      {
         try
         {
            $userHash = md5($_SERVER['HTTP_USER_AGENT'] . $_COOKIE['highlogin']);

            $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,eval(PDO_UTF));
            $STH = $DBH->prepare("SELECT id FROM `session` WHERE hash = :userHash");
            $STH->bindValue(':userHash',$userHash);
            $STH->execute();
            SQL_Error($STH);
            
            if ($STH->rowCount() == 1)
            {
                session_start();
                
                $row = $STH->fetch();
                $_SESSION['user_id'] = $row['id'];
                
                return TRUE;
            }
            else
            {
                setcookie('highlogin', "", time() - (60 * 60 * 24 * 100), '/'); // удаляем
                
                return FALSE;
            }            
         }
         catch(PDOException $e)
         {
            throw new siteException($e->getMessage());
         }
      }

      return FALSE;
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
            //header("Location: .".substr($_SERVER[PHP_SELF], 0,-4)."?cook");
            header('Location: ./login?cook');
            die();
         }
         else if (!isset($_COOKIE['cookcheck']))
         {
            return 0;
         }
         else 
         {
            header("Location: .".substr($_SERVER[PHP_SELF], 0,-4));
            die();
         }
      }
      
      return 1;
   }
   
   /**
    * Initialization user 
    *
    * @return array
    */
   function initUser($id = NULL) 
   {
      if (is_null($id) && (!isset($_SESSION['user_id'])))
      {
         throw new siteException("Error: не найден id пользователя.");
      }
      else if (is_null($id))
      {
         $id = $_SESSION['user_id'];
      }
      
      try
      {
         $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,eval(PDO_UTF));
         $STH = $DBH->prepare("SELECT * FROM `user` WHERE id = :id");
         $STH->bindValue(':id',$id);
         $STH->execute();
         SQL_Error($STH);
          
         if (!$STH->rowCount())
         {
            throw new siteException("Error: не найдено соответствие по id.");
         }
         else if ($STH->rowCount() == 1)
         {
            $user = $STH->fetch();
            return $user;
         }
         else
         {
            throw new siteException('Произошла ошибка номер 666. Обратитесь к админестратору.');
         }
      }
      catch (PDOException $e)
      {
         throw new siteException($e->getMessage());
      }
   }
   
} // END

?>