<?php
//print_r($_GET);
//print_r($_SERVER);
include("./class/controller/news.php");

$news = new News_Controller;

$news->run();

?>