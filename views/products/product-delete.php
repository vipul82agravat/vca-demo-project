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
     * verifyAuthUserToken method is chekck access the page before validate the user is authorized or not
     * it is validate the user id
     * * it is validate the user token
     * if user is not authorized then it will redirect to login page
     * if user is valid and authorized then it will access the admin panel
     */


    $masterObject = new Helpercls();
    $masterObject->verifyAuthUserToken();

    $id=$_GET['id'];

    /*
     *  delete function  is used to delete dataform table
     *  $table name of table you wont to delete data
     * $id which records you need to delete set the recotds id
     * return the response of delete records
     *  1 delete susscfully
     * 0 Not delete
     */

    $productDeleteData=$masterObject->delete('products',$id);

    if($productDeleteData['status']==1){

            header('Location:../../views/products/product-index.php?is_error=0&message='.$productDeleteData['message']);
    }else{
            header('Location:../../views/products/product-index.php?is_error=1&message='.$productDeleteData['message']);
    }
