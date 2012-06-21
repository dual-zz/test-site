<?php

require_once 'class/lib/twig.php';

/**
 * Genegal View funckion
 */
class Site_View extends Twig_Config {
   
   /**
    * ERROR
    */
   public function print_error($data)
   {
      $data['title'] = 'Error';
      echo $this->twig->render('error.htm', $data); 
   }
   
} // END

?>