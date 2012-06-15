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
      try
      {
         $data['online'] = $this->model->auth_check();
         
         if (!$this->model->cookcheck())
         {
            $data['error'] = '<h2>Для авторизации включите cookies в вашем браузере.</h2>';
            $this->view->print_login($data);
            //$this->view->print_cookOff();
         }
         else
         {
            if ($data['online'] == TRUE)
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
            }
            else
            {
                $this->view->print_login($data);
            }
         }
      }
      catch (siteException $ee)
      {
         $data['error'] = $ee->getMessage();
         $this->view->print_login($data);
         //$this->view->print_loginErr($ee->getMessage());
      }
   }
}

?>