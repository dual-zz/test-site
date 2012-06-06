<?php

include('./class/model/login.php');
include('./class/view/login.php');

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
      if ($this->model->do_auth)
      {
          ;
      }
      
      if ($this->model->auth_check())
      {
         header('Location: ./news');
      }
      else
      {
          $this->view->print_login();
      }
   }
}

?>