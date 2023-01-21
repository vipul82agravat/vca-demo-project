<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$message="Welcome to Admin Protal.";
$status=1;
$is_error=0;
if(isset($_GET['user-data']) and $_GET['user-data']!=""){

    $userdata=base64_decode($_GET['user-data']);
    $userDetails=explode('&',$userdata);
    $type=explode('=',$userDetails[0])[1];
    $email=explode('=',$userDetails[1])[1];

    if($type=='Active'){

        $table="users";
        $data="WHERE email='".$email."'";

        $masterObject = new Helpercls();
        $checkEmailReponse=$masterObject->userEmailExists($table,$data);
        $row = mysqli_fetch_assoc($checkEmailReponse['data']);

            session_start();
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            $username=$row['name'];
            $id=$row['id'];
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $status=1;
            $tokendata="status =  '".$status."', auth_token =  '".$token."'";
            $tokenResponse=$masterObject->updateUserSessionToken($table,$tokendata,$id);
            $message="Welcome to Admin Protal now your account was successfully activated.";
            $status=1;
            $is_error=0;
    }

}
/*
 * AuthUser method is chekck access the page before validate the Auth class have seesion is exits or nor
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

$parameters = [
    'is_error' => $is_error,
    'status' =>$email,
    'message'=>$message,
];

 // Render our view
 echo $twig->render('/users/user-index.html.twig',$parameters);
