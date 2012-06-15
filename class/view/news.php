<?php

//require_once 'class/lib/Twig/My_Twig_Config.php';

require_once 'class/lib/Twig/Autoloader.php';


/**
 * News view
 */
class news_view {
	
	function __construct()
	{
      ;
	}
   
   public function print_news($user)
   {
      Twig_Autoloader::register();
      
      $loader = new Twig_Loader_Filesystem(array('./html','./html/templates'));
      $twig   = new Twig_Environment($loader, array(
        'cache' => FALSE,
      ));
      
      $user['title'] = 'News';
      echo $twig->render('news.htm', $user);
   }
   
   public function print_in()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_in.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/news.htm");
      include("./html/pattern/footer.htm");
   }
   
   public function print_out()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/news.htm");
      include("./html/pattern/footer.htm");
   }
}

?>