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

    if(isset($_GET['start_date']) and  $_GET['start_date'] !=""){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        $data=" WHERE products_comments.create_at BETWEEN '".$start_date."' AND '".$end_date."'";

    }else{
        $data="";
    }

    $table1="products_comments";
    $table2="products";
    $selectData="products_comments.id as id,products_comments.comments as comments,products.title as products_name,products_comments.product_id as product_id";
    $productCommentData=$masterObject->leftJoinData($table1,$table2,'product_id','id',$data,$selectData);
    if (mysqli_num_rows($productCommentData['data']) > 0) {

        $i=0;
        $productCommentrow=array();
        while ($commentrow = mysqli_fetch_array($productCommentData['data'])) {

            $productCommentrow[$i]['number']=$i+1;
            $productCommentrow[$i]['id']=$commentrow['id'];
            $productCommentrow[$i]['comments']=$commentrow['comments'];
            $productCommentrow[$i]['product_name']=$commentrow['products_name'];
            $i++;
        }

    }

$parameters = [
        'is_error' => $_GET['is_error'],
        'message'=>$_GET['message'],
        'row'=>$productCommentrow,
        'user_role'=>$loginUserRole,
        'start_date'=>($start_date) ? $start_date : "",
        'end_date'=>($end_date) ? $end_date : "",
        'menu_status_comment' => 'active'
    ];

     // Render our view
     echo $twig->render('/products/product-comment-index.html.twig',$parameters);
