<?php

require_once './class/database/config.php';

require_once './class/model/login.php';
require_once './class/view/login.php';

/**
 * Login controller
 */
class Login_Controller {

   private $model;
   private $view;
   
   function __construct()
   {
      $this->model = new Login_Model;
      $this->view  = new Login_View;
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