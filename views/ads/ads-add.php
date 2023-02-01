<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

/*
 * AuthUser method is check access the page before validate the Auth user have seesion is exits or nor (login or nor)
 * if session is  not  extis then  is not authorized then it will redirect to login page
 * if user session is valid and authorized then it will access the admin panel
 * call the static class for checking
 */

//Auth::AuthUser();

/*
 * verifyAuthUserToken method is check access the page before validate the user is authorized or not
 * it is validate the user id
 * * it is validate the user token
 * if user is not authorized then it will redirect to login page
 * if user is valid and authorized then it will access the admin panel
 */
$masterObject = new Helpercls();
$masterObject->verifyAuthUserToken();

$table='products';

$data=" WHERE status='1'";

/*Get the category data base on user condtion
$id user login id it return all  user added category
$table - name of table for get the category data
$data the condition of get data base in user id
*/
$productsData=$masterObject->ShowConditionalBaseDetails($table,$data);
$productsDataresult=array();
if (mysqli_num_rows($productsData['data']) >= 0) {

    $i=0;

    while ($row = mysqli_fetch_array($productsData['data'])) {

        $productsDataresult[$i]['id']=$row['id'];
        $productsDataresult[$i]['name']=$row['title'];
        $i++;
    }

}

if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}
$ads_sort_number=[1,2,3,4];
$ads_position  =['left','right','top','bottom'];
$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>$_GET['message'],
    'server_error'=>$server_error,
    'products'=>$productsDataresult,
    'ads_sort_number'=>$ads_sort_number,
    'ads_position'=>$ads_position
];
 // Render our view
 echo $twig->render('/ads/ads-add.html.twig',$parameters);
