<?php

require_once 'class/lib/Twig.php';

/**
 * Register view
 */
class Register_View extends Twig_Config{
   
   private $twig;
   
   function __construct()
   {
      $this->twig = $this->Auto_Twig();
   }
   
   public function print_reg($data)
   {
      $data['title'] = 'Register';
      echo $this->twig->render('register.htm', $data);
   }
}
?>