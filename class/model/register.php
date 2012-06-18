<?php

//require_once './class/model/site.php';
require_once './class/model/login.php';

/**
 * Register model
 */
class Register_Model extends Login_Model {
   
   public $do_reg;
   public $user;
   
   private $login;
   private $email;
   private $pass;
   private $pass2;
   
   function __construct()
   {
      $this->do_reg = $_POST['do_reg'];
   }
   
   /**
    * Validate entered data
    *
    * @return int
    */
   private function dataValidation()
   {
      if ((!isset($_POST['login'])) || (!isset($_POST['email'])) || 
          (!isset($_POST['pass']))  || (!isset($_POST['pass2'])))
      {
         throw new siteException("Заполните все поля.");
      }
      else
      {
         $this->login = $_POST['login'];
         $this->email = $_POST['email'];
         $this->pass  = $_POST['pass'];
         $this->pass2 = $_POST['pass2'];
      }
      
      if (strcmp($this->pass,$this->pass2) != 0)
      {
         throw new siteException("Введённые пароли не совпадают.");
      }
      else if (!preg_match("/^.{6,20}$/", $this->pass))
      {
         throw new siteException("Пароль не соответствует требованиям.");
      }
      else if (!preg_match("/^[\-\.a-zA-Z0-9]+@[a-z\-]+\.[a-zA-Z]+\.?[a-zA-Z]*$/", $this->email))
      {
         throw new siteException("Введённый адрес ел. почты не корректен.");
      }
      else if (!preg_match("/^[\-\_a-zA-Z0-9]+$/", $this->login))
      {
         throw new siteException("Введённый логин не корректен.");
      }
      else 
      {
         return 1;
      }
   }

   private function bdaseValid()
   {
      try
      {
         $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
         $STH = $DBH->prepare("SELECT * FROM `user` WHERE login = :login");
         $STH->bindValue(':login',$this->login);
         $STH->execute();
         SQL_Error($STH);
         
         if ($STH->rowCount())
         {
            throw new siteException("Введёный логин уже используется.");
         }
         else 
         {
             $STH1 = $DBH->prepare("SELECT * FROM `user` WHERE email = :email");
             $STH1->bindValue(':email',$this->email);
             $STH1->execute();
             SQL_Error($STH1);
             
             if ($STH1->rowCount())
             {
                throw new siteException("Введённый адрес эл. почты уже используется.");
             }
         }
           
         return 1;
      }
      catch(PDOException $e)
      {
         throw new siteException($e->getMessage());
      }  
   }
   
   /**
    * do register
    */
   public function register()
   {
      if ($this->dataValidation())
      {
         if ($this->bdaseValid())
         {
            try
            {
               $DBH = new PDO(PDO_CONNECT_HOST,PDO_CONNECT_USER,PDO_CONNECT_PASS,$PDO_UTF8);
               $STH = $DBH->prepare("INSERT INTO `user` (login,email,pass)
                                     VALUES (:login,:email,:pass)");
               $STH->bindValue(':login',$this->login);
               $STH->bindValue(':email',$this->email);
               $STH->bindValue(':pass' ,$this->pass);
               $STH->execute();
               SQL_Error($STH);
               
               return 1;
            }
            catch(PDOException $e)
            {
               throw new siteException($e->getMessage());
            }
         }
      }
   }
   
}
?>