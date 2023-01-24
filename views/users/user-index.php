<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$message="Welcome to Admin Protal.";
$login_status=1;

/*
 * Check if user is redirect form email links at that time user is inActive and not access to panel so first time is must be active the account form email links
 * check the user is valid
 * if user use valid so active the user and login to that account automatically login with user id
 *
 */
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
            $login_status=1;

    }

}
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

    $table1="users";
    $table2="role_users";
    $selectData="users.id as user_id,users.name as name,users.status as status,users.email as email,role_users.role_id as role_id";
    $userData=$masterObject->leftJoinData($table1,$table2,'id','user_id',$data=null,$selectData);


    if (mysqli_num_rows($userData['data']) > 0) {

        $i=0;
        $result=array();
        while ($row = mysqli_fetch_array($userData['data'])) {

            $result[$i]['id']=$row['user_id'];
            $result[$i]['name']=$row['name'];
            $result[$i]['email']=$row['email'];
            $result[$i]['role_id']=$row['role_id']!="" ? $row['role_id'] : 2;
            $result[$i]['status']=$row['status']==1 ? "Active" : "InActive";
            $i++;

        }
    }
    $parameters = [
        'is_error' => $is_error,
        'status' =>$login_status,
        'message'=>$message,
        'row'=>$result,
        'user_role'=>$loginUserRole

    ];
        // Render our view
 echo $twig->render('/users/user-index.html.twig',$parameters);
