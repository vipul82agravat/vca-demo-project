<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$masterObject = new Helpercls();
$id=$_GET['id'];
$selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
$data=' WHERE products.id ='.$id;

$productData=$masterObject->getProductDetails($data,$selectData);
$row="";
if (mysqli_num_rows($productData['data']) > 0) {
    $row = mysqli_fetch_assoc($productData['data']);

}
$parameters = [
    'is_error' => $is_error,
    'status' =>$login_status,
    'message'=>$message,
    'product'=>$row,
    'user_role'=>$loginUserRole,
    'product_id'=>$id

];

 // Render our view
 echo $twig->render('/users/user-products-view.html.twig',$parameters);
