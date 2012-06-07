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
      if ($this->model->auth_check())
      {
         $this->view->print_in();
      }
      else
      {
          $this->view->print_out();
      }
   }
}

?>