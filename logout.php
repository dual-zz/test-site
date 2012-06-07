<?php

  session_name('lowlogin');
  session_start();
  
  session_unset();
  
  if (ini_get('session.use_cookies'))
  {
     $params = session_get_cookie_params();
     setcookie(  session_name(), '', time() - 42000, 
              $params["path"], $params["domain"],
              $params["secure"], $params["httponly"]
           );
  }
  
  session_destroy();
  
  if (isset($_COOKIE['highlogin']))
  {
     setcookie('highlogin', "", time() - (60 * 60 * 24 * 100), '/'); // удаляем
  }
  
  header("Location: .");

?>