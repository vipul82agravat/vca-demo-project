<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

/*
 * AuthUser method is chekck access the page before validate the Auth user have seesion is exits or nor
 * if session is  not  extis then  is not authorized then it will redirect to login page
 * if user session is valid and authorized then it will access the admin panel
 * call the static class for checking
 */

Auth::AuthUser();

/*
 * verifyAuthUserToken method is chekck access the page before validate the user is authorized or not
 * it is validate the user id
 * * it is validate the user token
 * if user is not authorized then it will redirect to login page
 * if user is valid and authorized then it will access the admin panel
 */
$masterObject = new Helpercls();
$masterObject->verifyAuthUserToken();
$loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());

if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}

$parameters = [
    'is_error' => $is_error,
    'status' =>$email,
    'message'=>$message,
    'user_role'=>$loginUserRole,
    'server_error'=>$server_error
];
    //print_r($parameters);exit;
 // Render our view
 echo $twig->render('/category/category-add.html.twig',$parameters);
