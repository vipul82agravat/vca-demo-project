<?php
$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

    if(isset($_GET['message']) and $_GET['message']!="")
    {
       $message=$_GET['message'];
       $status=1;
       $is_error=1;

    }else{
        $message="";
        $status=0;
        $is_error=0;
    }
    session_start();
    $parameters = [
        'is_error' => $is_error,
        'status' =>$status,
        'message'=>$message,
        'login_status' =>$_SESSION['username'] ? 1 : 0,
    ];

 // Render our view
 echo $twig->render('/users/login.html.twig',$parameters);
