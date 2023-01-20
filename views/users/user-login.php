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
    $parameters = [
        'is_error' => $is_error,
        'status' =>$email,
        'message'=>$message,
    ];

 // Render our view
 echo $twig->render('/users/login.html.twig',$parameters);
