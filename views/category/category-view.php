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

    //Auth::AuthUser();

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
$id=$_GET['id'];
$categoyShowData=$masterObject->ShowIdBaseDetails('categories',$id);
    if (mysqli_num_rows($categoyShowData['data']) > 0) {
         $row = mysqli_fetch_assoc($categoyShowData['data']);
           $id= $row['id'];
           $name= $row['name'];
           $status= $row['status'];
           $description= $row['description'];

    }

$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>$_GET['message'],
    'id'=>$id,
    'name'=>$name,
    'status'=>$status,
    'description'=>$description,
    'user_role'=>$loginUserRole
];

 // Render our view
 echo $twig->render('/category/category-view.html.twig',$parameters);
