<?php
$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

session_start();
$parameters = [
    'status' =>$_SESSION['username'] ? 1 : 0,

];
 // Render our view
 echo $twig->render('/users/registration.html.twig',$parameters);
