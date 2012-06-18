<?php

require_once 'class/lib/Twig.php';

/**
 * Login view
 */
class Login_View extends Twig_Config{
   
   private $twig;
   
   function __construct()
   {
      $this->twig = $this->Auto_Twig();
   }
   
   public function print_login($data)
   {
      $data['title'] = 'Login';
      echo $this->twig->render('login.htm', $data);
   }
}
?>