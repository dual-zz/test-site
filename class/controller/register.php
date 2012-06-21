<?php

require './class/database/config.php';

require './class/model/register.php';
require './class/view/register.php';

/**
 * Register controller
 */
class Register_Controller {
   
   public function run() 
   {
      try
      {
         $model = new Register_Model;
         $view  = new Register_View;
         $data;
         
         $data['online'] = $model->auth_check();

         if ($data['online'] == TRUE)
         {
            header('Location: ./news');
         }
         else if ($model->do_reg)
         {
            if ($model->register())
            {
               $data['registered'] = TRUE;
               $view->print_reg($data);
            }
         }
         else
         {
            $view->print_reg($data);
         }
      }
      catch (siteException $ee)
      {
         $data['error'] = $ee->getMessage();
         $view->print_reg($data);
      }
   }
}

?>