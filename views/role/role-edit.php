<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

/*
 * AuthUser method is check access the page before validate the Auth user have seesion is exits or nor (login or not)
 * if session is  not  extis then  is not authorized then it will redirect to login page
 * if user session is valid and authorized then it will access the admin panel
 * call the static Auth class for checking
 */

Auth::AuthUser();

/*
 * verifyAuthUserToken method is check access the page before validate the user is authorized or not
 * it is validate the user id
 * it is validate the user token
 * if user is not authorized then it will redirect to login page
 * if user is valid and authorized then it will access the admin panel
 */
$masterObject = new Helpercls();
$masterObject->verifyAuthUserToken();

$id=$_GET['id'];
$roleShowData=$masterObject->ShowIdBaseDetails('role',$id);
    if (mysqli_num_rows($roleShowData['data']) > 0) {
         $row = mysqli_fetch_assoc($roleShowData['data']);
           $id= $row['id'];
           $name= $row['name'];
           $status= $row['status'];
           $status_code= $row['status_code'];
           $description= $row['description'];
    }
if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}

$parameters = [
        'is_error' => $_GET['is_error'],
        'message'=>$_GET['message'],
        'id'=>$id,
        'name'=>$name,
        'status'=>$status,
        'status_code'=>$status_code,
        'description'=>$description,
        'data'=>$row,
        'server_error'=>$server_error
    ];
 // Render our view
 echo $twig->render('/role/role-edit.html.twig',$parameters);
