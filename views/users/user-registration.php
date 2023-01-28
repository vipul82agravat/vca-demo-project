<?php
$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

session_start();
if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}

$parameters = [
    'login_status' =>$_SESSION['username'] ? 1 : 0,
    'server_error'=>$server_error

];
 // Render our view
 echo $twig->render('/users/registration.html.twig',$parameters);
