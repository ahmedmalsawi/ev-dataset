<?php 
include 'connect.php';

//routes

$tpl = 'includes/templates/'; // Templates directory
$lang = 'includes/languages/'; // Language directory
$func = 'includes/functions/'; // Functions directory
$css = 'layout/css/'; // Css directory
$js = 'layout/js/'; // JavaScript directory
// echo $tp1;



//include important files
include $func ."functions.php";
include $lang.'en.php';
include $tpl. "header.php";

// include na in all pages expet for those which have var called $noNavbar
if(!isset($noNavbar)){ include $tpl. "navbar.php";}