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
/*
 * check userRoleCheck  this function what is the role of given user id
 * it return the number or  id  of role
 * $id user id pass in mathod paramters
 */
$loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());

    $id=Auth::AuthUserId();
    $table='categories';
    $data="";
    if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        $data=" WHERE categories.create_at BETWEEN '".$start_date."' AND '".$end_date."'";

    }
    if($loginUserRole!=1){
        if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
            $start_date=$_GET['start_date'];
            $end_date=$_GET['end_date'];
            $data=" WHERE categories.create_at BETWEEN '".$start_date."' AND '".$end_date."' AND categories.user_id =".$id;
        }else{
            $data=" WHERE categories.user_id =".$id;
        }

    }
/*Get the category data base on user auth data
$id user login id it return all  user added category
$table - name of table for get the category data
$data the condition of get data base in user id
*/

$categoyData=$masterObject->ShowConditionalBaseDetails($table,$data);

 if (mysqli_num_rows($categoyData['data']) > 0) {

        $i=0;
        $result=array();
        while ($row = mysqli_fetch_array($categoyData['data'])) {

                $result[$i]['id']=$row['id'];
                $result[$i]['name']=$row['name'];
                $result[$i]['user_id']=$row['user_id'];
                $result[$i]['status']=$row['status']==1 ? "Active" : "InActive";
                $result[$i]['description']=$row['description'];
                $i++;

        }
}
$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>$_GET['message'],
    'row'=>$result,
    'user_role'=>$loginUserRole,
    'start_date'=>($start_date) ? $start_date : "",
    'end_date'=>($end_date) ? $end_date : "",
    'menu_status_category' => 'active'
];

 // Render our view
 echo $twig->render('/category/category-index.html.twig',$parameters);
