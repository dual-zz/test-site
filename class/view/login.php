<?php

require_once 'class/view/site.php';

/**
 * Login view
 */
class Login_View extends Site_View {
   
   protected $twig;
   
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