<?php

if (isset($_GET['qwer']))
{
   die('nya');
}

//print_r($_GET);
//print_r($_SERVER);
include("./class/controller/news.php");

$news = new News_Controller;

$news->run();

?>