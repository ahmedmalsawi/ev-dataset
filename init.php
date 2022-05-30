<?php 

ini_set('display_errors','on');
error_reporting(E_ALL);
include 'admin/connect.php';
$sessionUser='';
if(isset($_SESSION['user'])){
    $sessionUser=$_SESSION['user'];
}
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