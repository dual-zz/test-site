<?php

require_once './class/database/config.php';

require_once './class/model/login.php';
require_once './class/view/login.php';

/**
 * Login controller
 */
class Login_Controller {
   
   public function run()
   {
      try
      {
         $model = new Login_Model;
         $view  = new Login_View;
         $data;
         
         $data['online'] = $model->auth_check();
         
         if (!$model->cookcheck())
         {
            $data['error'] = 'Для какой-либо активности на сайте, включите cookies в вашем браузере.';
            $view->print_login($data);
         }
         else if ($data['online'] == TRUE)
         {
            header('Location: ./news');
            die();
         } 
         else if ($model->do_auth)
         {
            $STH = new PDOStatement;
            $auth = $model->sign_in($STH); 
            if (!$auth)
            {
               header('Location: ./news');
               die();
            }
         }
         else
         {
             $view->print_login($data);
         }
      }
      catch (siteException $ee)
      {
         $data['error'] = $ee->getMessage();
         $view->print_login($data);
      }
   }
}

?>