<?php

require_once 'class/view/site.php';

/**
 * News view
 */
class News_View extends Site_View {
	
   protected  $twig;
   
	function __construct()
	{
      $this->twig = $this->Auto_Twig();
	}
   
   public function print_news($data)
   {
      $data['title'] = 'News';
      echo $this->twig->render('news.htm', $data);
   }
}
?>