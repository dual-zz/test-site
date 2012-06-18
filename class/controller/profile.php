<?php

require './class/database/config.php';

require './class/model/profile.php';
require './class/view/profile.php';

/**
 * Profile controller
 */
class Profile_Controller {

   /*
   private $model;
   private $view;
   
   function __construct()
   {
      $this->model = new profile_mod;
      $this->view  = new profile_view;
   }
   */
   
   public function run()
   {
      $model = new profile_mod;
      $view  = new profile_view;
      
      try
      {
         if (!$model->edit)
         {
             $view;
         }
         else 
         {
             ;
         }
      }
      catch (siteException $ee)
      {
         $this->view->print_profile_err($ee->getMessage());
      }
   }
}//END

?>