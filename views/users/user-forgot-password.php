<?php

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}


 $parameters = [
 'my_var' => 'Hello world !!!',
 'server_error'=>$server_error
 ];

 // Render our view
 echo $twig->render('/users/forget-password.html.twig', $parameters);
