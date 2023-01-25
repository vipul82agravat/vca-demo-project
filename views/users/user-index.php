<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;
$login_status=1;
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
    $data=null;
    if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        $data=" WHERE users.create_at BETWEEN '".$start_date."' AND '".$end_date."'";

    }
    $table1="users";
    $table2="role_users";

    $selectData="users.id as user_id,users.name as name,users.status as status,users.email as email,role_users.role_id as role_id";
    $userData=$masterObject->leftJoinData($table1,$table2,'id','user_id',$data,$selectData);

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
        'user_role'=>$loginUserRole,
        'start_date'=>($start_date) ? $start_date : "",
        'end_date'=>($end_date) ? $end_date : ""

    ];
        // Render our view
 echo $twig->render('/users/user-index.html.twig',$parameters);
