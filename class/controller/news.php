<?php

require './class/database/config.php';

require './class/model/news.php';
require './class/view/news.php';

/**
 * News controller
 */
class news_con {

	private $model;
   private $view;
   
	function __construct()
	{
      $this->model = new news_mod;
      $this->view  = new news_view;
	}
   
   public function run()
   {
      try
      {
         if ($this->model->auth_check())
         {
            $data = $this->model->initUser();
            $data['online'] = TRUE;
            $this->view->print_news($data);
         }
         else
         {
            $data['online'] = FALSE;
            $this->view->print_news($data);
         }
      }
      catch (siteException $ee)
      {
         echo "Error: ".$ee->getMessage();
      }
      
   }
}

?>