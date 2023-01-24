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

    $id=Auth::AuthUserId();
    $table='products';
    $data="";
    if($loginUserRole!=1){
        $data=' WHERE products.user_id ='.$id;
    }
    /*Get the category data base on user auth data
    $id user login id it return all  user added category
    $table - name of table for get the category data
    $data the condition of get data base in user id
    */
    $table1="categories";
    $table2="products";
    $table3="states";
    $table2="states";
    $table2="products";
    $selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
    //    $productData=$masterObject->rightJoinData($table1,$table2,'id','category_id',$data,$selectData);
    /*
    * getProductDetails function used to get the product details with join data base on category,state,city
    * $data pass and where condidtion if require
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
        'is_error' => $is_error,
        'status' =>1,
        'message'=>$message,
        'row'=>$result
    ];

     // Render our view
     echo $twig->render('/products/product-index.html.twig',$parameters);
