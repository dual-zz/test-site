<?php

require_once 'class/view/site.php';

/**
 * Register view
 */
class Register_View extends Site_View {
   
   protected $twig;
   
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