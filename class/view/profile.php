<?php

require_once 'class/view/site.php';

/**
 * Profile view
 */
class Profile_View extends Site_View {
   
   protected  $twig;
   
   function __construct()
   {
      $this->twig = $this->Auto_Twig();
   }
   
   public function print_profile($data)
   {
      $data['title'] = 'Profile';
      echo $this->twig->render('profile.htm', $data);
   }
   
   public function print_profile_edit($data)
   {
      $data['title'] = 'Profile';
      echo $this->twig->render('profile_edit.htm', $data);
   }
}
?>