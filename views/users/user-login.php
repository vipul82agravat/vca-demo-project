<?php
$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

    $message="";
    $is_error=0;
    if(isset($_GET['message']) and $_GET['message']!="")
    {
       $message=$_GET['message'];
       $is_error=$_GET['is_error'];
    }
    session_start();
    $parameters = [
        'is_error' => $_GET['is_error'],
        'message'=>$_GET['message'],
        'login_status' =>$_SESSION['username'] ? 1 : 0,
    ];

 // Render our view
 echo $twig->render('/users/login.html.twig',$parameters);
