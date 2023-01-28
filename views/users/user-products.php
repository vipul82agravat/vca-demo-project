<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$masterObject = new Helpercls();

$selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
$data=" ORDER BY products.create_at DESC;";
        /*
        * getProductDetails function used to get the product details with join data base on category,state,city
        * $data pass and where condidtion if require
        * $selectData select clounm list in response it pass alias name
        * it return the resonsedata base on all three table
        */
$productData=$masterObject->getProductDetails($data,$selectData);
$result=0;
if (mysqli_num_rows($productData['data']) > 0) {

    $i=0;
    $result=array();
    while ($row = mysqli_fetch_array($productData['data'])) {

        $result[$i]['title']=$row['title'];
        $result[$i]['id']=$row['product_id'];
        $result[$i]['category_id']=$row['category_id'];
        $result[$i]['catgory_name']=$row['catgory_name'];
        $result[$i]['location']=$row['location'];
        $result[$i]['countries']=$row['countries'];
        $result[$i]['state']=$row['states_name'];
        $result[$i]['city']=$row['city_name'];
        $result[$i]['postcode']=$row['postcode'];
        $result[$i]['company_name']=$row['company_name'];
        $result[$i]['address']=$row['address'];
        $result[$i]['status']=$row['status']==1 ? "Active" : "InActive";
        $result[$i]['description']=$row['description'];
        $result[$i]['create_date']=$row['create_date'];
        $result[$i]['update_date']=$row['update_date'];
        $result[$i]['img_path']=$row['img_path'];
        $result[$i]['image']=$row['image'];
        $i++;

    }

}
session_start();
$parameters = [
    'is_error' => $_GET['is_error'],
    'status' =>$login_status,
    'message'=>$_GET['message'],
    'row'=>$result,
    'user_role'=>$loginUserRole,
    'login_status' =>$_SESSION['username'] ? 1 : 0,


];
 // Render our view
 echo $twig->render('/users/user-products.html.twig',$parameters);
