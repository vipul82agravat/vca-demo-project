<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

/*
 * AuthUser method is check access the page before validate the Auth user have seesion is exits or nor
 * if session is  not  extis then  is not authorized then it will redirect to login page
 * if user session is valid and authorized then it will access the admin panel
 * call the static class for checking
 */

    Auth::AuthUser();

/*
 * verifyAuthUserToken method is check access the page before validate the user is authorized or not
 * it is validate the user id
 * * it is validate the user token
 * if user is not authorized then it will redirect to login page
 * if user is valid and authorized then it will access the admin panel
 */
$masterObject = new Helpercls();
//$masterObject->verifyAuthUserToken();

$id=$_GET['id'];
$row="";
$productCommentShowData=$masterObject->ShowIdBaseDetails('products_comments',$id);
if (mysqli_num_rows($productCommentShowData['data']) > 0) {
    $row = mysqli_fetch_assoc($productCommentShowData['data']);

}

 /*
    * userRoleCheck method is usd to check login user role
    * like login user is admin.super-admin ,etc
    * it return role id
    */
$loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());

$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>$_GET['message'],
    'data'=>$row,
    'user_role'=>$loginUserRole
];
//print_r($parameters);exit;
// Render our view
echo $twig->render('/products/product-comment-view.html.twig',$parameters);
