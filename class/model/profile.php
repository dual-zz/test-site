<?php

require './class/model/site.php';

/**
 * Login model
 */
class profile_mod extends site {
   
   public $edit;
   
   function __construct()
   {
      $this->edit = (isset($_GET['edit'])) ? 1 : 0;
   }
}
?>