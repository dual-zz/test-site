<?php

require_once 'class/lib/Twig/Autoloader.php';

/**
 * Login view
 */
class login_view {
   
   function __construct()
   {
      ;
   }
   
   public function print_login($user)
   {
      Twig_Autoloader::register();
      
      $loader = new Twig_Loader_Filesystem(array('./html','./html/templates'));
      $twig   = new Twig_Environment($loader, array(
        'cache' => FALSE,
      ));
      
      $user['title'] = 'Login';
      echo $twig->render('login.htm', $user);
   }
   
   public function print_login_()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/login/login.htm");
      include("./html/pattern/footer.htm");
   }
   
   public function print_loginErr($error)
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/login/loginErr.htm");
      include("./html/pattern/footer.htm");
   }
   
   /**
    * Cookie is off
    */
   public function print_cookOff()
   {
      include("./html/pattern/head_0.htm");
      include("./html/pattern/head_1.htm");
      include("./html/interface/sign_out.htm");
      include("./html/pattern/head_2.htm");
      include("./html/model/login/checkErr.htm");
      include("./html/pattern/footer.htm");
   }
}

?>