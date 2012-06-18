<?php

require_once 'class/lib/Twig/Autoloader.php';


class Twig_Config {
	
	function Auto_Twig()
	{
		Twig_Autoloader::register();
      
      $loader = new Twig_Loader_Filesystem(array('./html','./html/templates'));
      $twig   = new Twig_Environment($loader, array(
        'cache' => FALSE,
      ));
      return $twig;
	}
}


?>