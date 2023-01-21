<?php
$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

 // Render our view
 echo $twig->render('/users/registration.html.twig');
