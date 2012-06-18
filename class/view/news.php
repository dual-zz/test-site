<?php

require_once 'class/lib/twig.php';

/**
 * News view
 */
class News_View extends Twig_Config {
	
   private  $twig;
   
	function __construct()
	{
      $this->twig = $this->Auto_Twig();
	}
   
   public function print_news($user)
   {
      $user['title'] = 'News';
      echo $this->twig->render('news.htm', $user);
   }
}
?>