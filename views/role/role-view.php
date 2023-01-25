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
$id=$_GET['id'];
$categoyShowData=$masterObject->ShowIdBaseDetails('role',$id);
    if (mysqli_num_rows($categoyShowData['data']) > 0) {
         $row = mysqli_fetch_assoc($categoyShowData['data']);
           $id= $row['id'];
           $name= $row['name'];
           $status= $row['status'];
           $status_code= $row['status_code'];
           $description= $row['description'];

    }

$parameters = [
    'is_error' => $is_error,
    'message'=>$message,
    'id'=>$id,
    'name'=>$name,
    'status'=>$status,
    'status_code'=>$status_code,
    'description'=>$description
];

 // Render our view
 echo $twig->render('/role/role-view.html.twig',$parameters);
