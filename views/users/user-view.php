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


$id=$_GET['id'];
$userRole=$masterObject->userRoleCheck($id);

$userShowData=$masterObject->ShowIdBaseDetails('users',$id);
if (mysqli_num_rows($userShowData['data']) > 0) {
    $row = mysqli_fetch_assoc($userShowData['data']);
}

$table='role';
$data=" WHERE status='1'";

/*Get the category data base on user auth data
$id user login id it return all  user added category
$table - name of table for get the category data
$data the condition of get data base in user id
*/
$roleData=$masterObject->ShowConditionalBaseDetails($table,$data);
if (mysqli_num_rows($roleData['data']) > 0) {

    $i=0;
    $role_result=array();
    while ($row1 = mysqli_fetch_array($roleData['data'])) {
        $role_result[$i]['id']=$row1['id'];
        $role_result[$i]['name']=$row1['name'];
        $role_result[$i]['status_code']=$row1['status_code'];
        $role_result[$i]['status']=$row1['status'];
        $i++;

    }
}

$parameters = [
    'is_error' => $is_error,
    'status' =>$email,
    'message'=>$message,
    'data'=>$row,
    'role_data'=>$role_result,
    'user_role'=>$userRole,
    'login_user_role'=>$loginUserRole

];
 // Render our view
 echo $twig->render('/users/user-view.html.twig',$parameters);
