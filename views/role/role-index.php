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

    $id=Auth::AuthUserId();
    $table='role';
    $data="";
    if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        $data=" WHERE role.create_at BETWEEN '".$start_date."' AND '".$end_date."'";

    }
/*Get the $roleData data base on user auth condtion
$id user login id it return all  user added role
$table - name of table for get the role data
$data the condition of get data base in user id
*/

$roleData=$masterObject->ShowConditionalBaseDetails($table,$data);

 if (mysqli_num_rows($roleData['data']) > 0) {

        $i=0;
        $result=array();
        while ($row = mysqli_fetch_array($roleData['data'])) {

                $result[$i]['id']=$row['id'];
                $result[$i]['name']=$row['name'];
                $result[$i]['status_code']=$row['status_code'];
                $result[$i]['status']=$row['status']==1 ? "Active" : "InActive";
                $result[$i]['description']=$row['description'];
                $i++;

        }




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
    'user_role'=>$loginUserRole,
    'row'=>$result,
    'start_date'=>($start_date) ? $start_date : "",
    'end_date'=>($end_date) ? $end_date : ""
];
 // Render our view
 echo $twig->render('/role/role-index.html.twig',$parameters);
