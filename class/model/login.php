<?php

/**
 * Login model
 */
class login_mod {
   
   public $do_auth;
   
   function __construct()
   {
      $this->do_auth = $_POST['act'];
   }
   
   public function auth_check()
   {
      session_name('lowlogin');
   
      if (isset($_REQUEST[session_name()]))
      {
         session_start();
         return 1;
      }
      else
      {
          return 0;
      }
   }
}


?>