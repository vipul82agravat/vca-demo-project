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
$HelperObject = new Helpercls();
$HelperObject->verifyAuthUserToken();



$id=1;
$table='products';
$data=' WHERE user_id ='.$id;

/*Get the category data base on user auth data
$id user login id it return all  user added category
$table - name of table for get the category data
$data the condition of get data base in user id
*/

$productData=$HelperObject->ShowConditionalBaseDetails($table,$data);

if (mysqli_num_rows($productData['data']) > 0) {

        $i=0;
        $result=array();
        while ($row = mysqli_fetch_array($productData['data'])) {

                $result[$i]['title']=$row['title'];
                $result[$i]['category_id']=$row['category_id'];
                $result[$i]['location']=$row['location'];
                $result[$i]['countries']=$row['countries'];
                $result[$i]['state']=$row['state'];
                $result[$i]['city']=$row['city'];
                $result[$i]['postcode']=$row['postcode'];
                $result[$i]['company_name']=$row['company_name'];
                $result[$i]['address']=$row['address'];
                $result[$i]['status']=$row['status'];
                $result[$i]['description']=$row['description'];
                $i++;

        }




}
$parameters = [
    'is_error' => $is_error,
    'status' =>$email,
    'message'=>$message,
    'row'=>$result
];
 // Render our view
 echo $twig->render('/products/product-index.html.twig',$parameters);
