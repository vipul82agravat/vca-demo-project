<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

 $userdata=base64_decode($_GET['user-data']);
 $userDetails=explode('&',$userdata);
    $token=explode('=',$userDetails[0])[1];
    $email=explode('=',$userDetails[1])[1];

     $masterObject = new Helpercls();

    /*
     * resetPasswordLinksStatus check the password resert link is active or expire id exripre can not change the password
     * $token -token whrn try to forget passowrd it return in paramter
     * $email - check the which user have require to change the password
     * $data is encode is we need to de code before send the paramters
     */
    $password_linsResponse=$masterObject->resetPasswordLinksStatus($email,$token);
    $password_linsResponse['status']==0 ? $linksStatus=0 : $linksStatus=1;

    $parameters = [
     'token' => $token,
         'email' =>$email,
         'linksStatus'=>$linksStatus,
     ];

// Render our view
 echo $twig->render('/users/user-password-reset.html.twig', $parameters);
