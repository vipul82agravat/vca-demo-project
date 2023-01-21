<?php

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

 $parameters = [
 'my_var' => 'Hello world !!!'
 ];

 // Render our view
 echo $twig->render('/users/forget-password.html.twig', $parameters);
