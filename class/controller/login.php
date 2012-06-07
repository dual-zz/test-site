<?php

require './class/database/config.php';

require './class/model/login.php';
require './class/view/login.php';

/**
 * Login controller
 */
class login_con {

   private $model;
   private $view;
   
   function __construct()
   {
      $this->model = new login_mod;
      $this->view  = new login_view;
   }
   
   public function run()
   {
      if (!$this->model->cookcheck())
      {
         $this->view->print_cookOff();
      }
      else
      {
         if ($this->model->auth_check())
         {
            header('Location: ./news');
         }
         else if ($this->model->do_auth)
         {
            $STH = new PDOStatement;
            $auth = $this->model->sign_in($STH); 
            if (!$auth)
            {
               header('Location: ./news');
            }
            else
            {
                $this->view->print_loginErr($auth);
            }
         }
         else
         {
             $this->view->print_login();
         }
      }
   }
}

?>