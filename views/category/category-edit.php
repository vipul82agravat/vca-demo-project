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
$check_auth = new Helpercls();
$check_auth->verifyAuthUserToken();
$id=$_GET['id'];
$categoyShowData=$check_auth->ShowIdBaseDetails('categories',$id);
    if (mysqli_num_rows($categoyShowData['data']) > 0) {
         $row = mysqli_fetch_assoc($categoyShowData['data']);
           $id= $row['id'];
           $name= $row['name'];
           $status= $row['status'];
           $description= $row['description'];

    }

$parameters = [
    'is_error' => $is_error,
    'status' =>$email,
    'message'=>$message,
    'id'=>$id,
    'name'=>$name,
    'status'=>$status,
    'description'=>$description
];

 // Render our view
 echo $twig->render('/category/category-edit.html.twig',$parameters);
