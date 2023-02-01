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

$table='products_ads';

$data=" WHERE status='1'";

/*Get the category data base on user condtion
$id user login id it return all  user added category
$table - name of table for get the category data
$data the condition of get data base in user id
*/
$productsData=$masterObject->ShowConditionalBaseDetails('products',$data);
$productsDataresult=array();
if (mysqli_num_rows($productsData['data']) >= 0) {

    $i=0;

    while ($row = mysqli_fetch_array($productsData['data'])) {

        $productsDataresult[$i]['id']=$row['id'];
        $productsDataresult[$i]['name']=$row['title'];
        $i++;
    }

}


$id=$_GET['id'];
$table2="products";
$tab1key="product_id";
$tab2key="id";
$data="Where products_ads.id=".$id;
$selectData="products.id as product_id,products.title as product_name,products.img_path as img_path,products_ads.ads_position as ads_position,products_ads.sort_number as sort_number,products_ads.start_date as start_date,products_ads.end_date as end_date,products_ads.status as status,products_ads.description as description,products_ads.id as id";
$adsData=$masterObject->leftJoinData($table,$table2,$tab1key,$tab2key,$data,$selectData);
//$roleShowData=$masterObject->ShowIdBaseDetails('products_ads',$id);
if (mysqli_num_rows($adsData['data']) > 0) {
    $row = mysqli_fetch_assoc($adsData['data']);
}
if(isset($_GET['server_error']) and $_GET['server_error']!=""){
    $server_error=explode(',',$_GET['server_error']);
}
$ads_sort_number=[1,2,3,4];
$ads_position  =['left','right','top','bottom'];
$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>$_GET['message'],
    'id'=>$id,
    'data'=>$row,
    'server_error'=>$server_error,
    'ads_sort_number'=>$ads_sort_number,
    'ads_position'=>$ads_position,
    'products'=>$productsDataresult,
    'start_date'=>date("Y-m-d", strtotime($row['start_date'])),
    'end_date'=> date("Y-m-d", strtotime($row['end_date']))

];
// Render our view
echo $twig->render('/ads/ads-edit.html.twig',$parameters);
