<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

    $bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
    require_once $bootstrap_file;


    /*
     * AuthUser method is check access the page before validate the Auth user have seesion is exits or nor
     * if session is  not  extis then  is not authorized then it will redirect to login page
     * if user session is valid and authorized then it will access the admin panel
     * call the static class for checking
     */

    Auth::AuthUser();

    /*
     * verifyAuthUserToken method is check access the page before validate the user is authorized or not
     * it is validate the user id
     * * it is validate the user token
     * if user is not authorized then it will redirect to login page
     * if user is valid and authorized then it will access the admin panel
     */
    $masterObject = new Helpercls();
    $masterObject->verifyAuthUserToken();
    /*
     * userRoleCheck method is usd to check login user role
     * like login user is admin.super-admin ,etc
     * it return role id
     */
    $loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());
    $id=Auth::AuthUserId();

    $table='products';
    $data="";
    if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        $data=" WHERE products.create_at BETWEEN '".$start_date."' AND '".$end_date."'";

    }
    if($loginUserRole!=1){
        if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
            $start_date=$_GET['start_date'];
            $end_date=$_GET['end_date'];
            $data=" WHERE products.create_at BETWEEN '".$start_date."' AND '".$end_date."' AND products.user_id =".$id;
        }else{
            $data=" WHERE products.user_id =".$id;
        }

    }

    /*Get $selectData id query string of get data form table base on clounm list
    */
    $selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";

    /*
    * getProductDetails function used to get the product details with join data base on category,state,city
    * $data pass and where condition if require
    * $selectData select clounm list in response it pass alias name
    * it return the resonsedata base on all three table
    */
    $productData=$masterObject->getProductDetails($data,$selectData);

//
//    $productData=$masterObject->ShowConditionalBaseDetails($table,$data);

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
    $parameters = [
        'is_error' => $_GET['is_error'],
        'message'=>$_GET['message'],
        'row'=>$result,
        'user_role'=>$loginUserRole,
        'start_date'=>($start_date) ? $start_date : "",
        'end_date'=>($end_date) ? $end_date : ""
    ];

     // Render our view
     echo $twig->render('/products/product-index.html.twig',$parameters);
