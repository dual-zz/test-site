<?php

require './class/model/site.php';

/**
 * Login model
 */
class login_mod extends site {
   
   public $do_auth;
   public $user;
   
   private $login;
   private $pass;
   private $remember;
   
   function __construct()
   {
      $this->do_auth = $_POST['do_auth'];
   }
   
   /**
    * Авторизация
    */
   public function sign_in(PDOStatement $STH)
   {
      $this->login = $_POST['login'];
      $this->pass  = $_POST['pass'];
      
      try
      {
         $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
         $STH = $DBH->prepare("SELECT * FROM `user` WHERE login = :login");
         $STH->bindValue(':login',$this->login);
         $STH->execute();
         SQL_Error($DBH);
         
         if (!$STH->rowCount())
         {
             throw new site("Неверный логин");
         }
         else if ($STH->rowCount() == 1)
         {
            $row = $STH->fetch();
            
            if ($row['pass'] != $this->pass)
            {
                throw new site("Неверный пароль");
            }
            else
            {
               session_name('lowlogin');
               session_start();
               $_SESSION['user'] = $row;
               $this->user = $row;
               
               if ($_REQUEST['forgetme'] != 'on')
               {
                  // highlogin
                  $salt = $this->gensalt(6);
                  $hashCook = md5(md5($pass) . md5($salt));
                  $hash = md5($_SERVER['HTTP_USER_AGENT'] . $hashCook);
                  
                  setcookie('highlogin', $hashCook, time() + (60 * 60 * 24 * 100), '/'); // 100 дней
                  
                  $STH1 = $DBH->prepare("SELECT * FROM `session` WHERE id = :id");
                  $STH1->bindValue(':id',$this->user['id']);
                  $STH1->execute();
                  SQL_Error($DBH);
                  
                  if (!$STH1->rowCount())
                  {
                     $STH2 = $DBH->prepare("INSERT INTO `session` (id, hash) VALUES (:id, :hash)");
                     $STH2->bindValue(':id',$this->user['id']);
                     $STH2->bindValue(':hash',$hash);
                     $STH2->execute();
                     SQL_Error($DBH);
                  }
                  else if ($STH1->rowCount() == 1)
                  {
                     $STH3 = $DBH->prepare("UPDATE `session` SET hash = :hash WHERE id = :id");
                     $STH3->bindValue(':id',$this->user['id']);
                     $STH3->bindValue(':hash',$hash);
                     $STH3->execute();
                     SQL_Error($DBH);
                  }
                  else
                  {
                      throw new site("Произошла ошибка номер 665. Обратитесь к админестратору.");
                  }
               }
            }
         }
         else
         {
             throw new site('Произошла ошибка номер 666. Обратитесь к админестратору.');
         }
      }
      catch(PDOException $e)
      {
         throw new site($e->getMessage());
      }
      catch(site $ee)
      {
         throw $ee;
      }
      
      return 0;
   }
      
   /**
    * function to salt generate (hightlogin hash cryto)
    */
   private function gensalt($count)
   {
      $rand = '';
   
      for ($i = 0; $i < $count; $i++) 
      {
         $rand .= chr(rand(33, 126));
      }
   
      return $rand;
   }  
}

?>