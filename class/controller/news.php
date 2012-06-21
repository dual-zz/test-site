<?php

require './class/database/config.php';

require './class/model/news.php';
require './class/view/news.php';

/**
 * News controller
 */
class News_Controller {

   public function run()
   {
      try
      {
         $model = new News_Model;
         $view  = new News_View;
         
         if ($model->auth_check(FALSE))
         {
            $data['user'] = $model->initUser();
            $data['online'] = TRUE;
            $view->print_news($data);
         }
         else
         {
            $data['online'] = FALSE;
            $view->print_news($data);
         }
      }
      catch (siteException $ee)
      {
         echo "Error: ".$ee->getMessage();
      }
      
   }
}

?>