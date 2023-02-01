<?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

    /*
     * AuthUser method is check access the page before validate the Auth user have session is exits or nor (login or not)
     * if session is  not  extis then  is not authorized then it will redirect to login page
     * if user session is valid and authorized then it will access the admin panel
     * call the static Auth class for checking
     */

        //Auth::AuthUser();

    /*
     * verifyAuthUserToken method is check access the page before validate the user is authorized or not
     * it is validate the user id of login user
     * * it is validate the user token of of login user
     * if user is not authorized then it will redirect to login page
     * if user is valid and authorized then it will access the admin panel
     */


    $masterObject = new Helpercls();
    $masterObject->verifyAuthUserToken();

    if(isset($_GET['server_error']) and $_GET['server_error']!=""){
        $server_error=explode(',',$_GET['server_error']);
    }

    /*
     * userRoleCheck method is usd to check login user role
     * like login user is admin.super-admin ,etc
     * it return role id
     */
    $loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());

    /*
     * Auth::AuthUserId(); is used to get the current user login user_id
     */
    $id=Auth::AuthUserId();
    $table='categories';

    if($loginUserRole==1){
         $data=" WHERE status='1'";
    }else{
        $data=" WHERE status='1' and user_id =".$id;
    }

    /*Get the category data base on user condtion
    $id user login id it return all  user added category
    $table - name of table for get the category data
    $data the condition of get data base in user id
    */
    $categoriesData=$masterObject->ShowConditionalBaseDetails($table,$data);

        $categoriesDataresult=array();
        if (mysqli_num_rows($categoriesData['data']) >= 0) {

            $i=0;

            while ($row = mysqli_fetch_array($categoriesData['data'])) {

                $categoriesDataresult[$i]['id']=$row['id'];
                $categoriesDataresult[$i]['name']=$row['name'];
                $categoriesDataresult[$i]['user_id']=$row['user_id'];
                $categoriesDataresult[$i]['status']=$row['status'];
                $categoriesDataresult[$i]['description']=$row['description'];
                $i++;

            }

        }


    /*Get the Countries data
    *$countriesDataresult to get ShowDetails() master function to response data and store in variable
     *Process data in with id and name formate and push in array variable
    */
    $countries=$masterObject->ShowDetails('countries');
    $countriesDataresult=array();
    if (mysqli_num_rows($countries['data']) >= 0) {

        $i=0;

        while ($row = mysqli_fetch_array($countries['data'])) {

            $countriesDataresult[$i]['id']=$row['id'];
            $countriesDataresult[$i]['name']=$row['name'];
            $countriesDataresult[$i]['countryCode']=$row['countryCode'];
            $i++;

        }

    }

    /*Get the states data
    *$statesDataresult to get ShowDetails() master function to response data and store in variable
     *Process data in with id and name formate and push in array variable
    */
    $states=$masterObject->ShowDetails('states');
    $statesDataresult=array();
    if (mysqli_num_rows($states['data']) >= 0) {

        $i=0;

        while ($row = mysqli_fetch_array($states['data'])) {

            $statesDataresult[$i]['id']=$row['id'];
            $statesDataresult[$i]['name']=$row['name'];
            $statesDataresult[$i]['countryCode']=$row['countryCode'];
            $i++;

        }

    }
    /*Get the cities data
    *$citiesDataresult to get ShowDetails() master function to response data and store in variable
     *Process data in with id and name formate and push in array variable
    */
    $cities=$masterObject->ShowDetails('cities');
    $citiesDataresult=array();
    if (mysqli_num_rows($cities['data']) >= 0) {

        $i=0;

        while ($row = mysqli_fetch_array($cities['data'])) {

            $citiesDataresult[$i]['id']=$row['id'];
            $citiesDataresult[$i]['name']=$row['city'];
            $citiesDataresult[$i]['state_id']=$row['state_id'];

            $i++;

        }

    }

    $parameters = [
            'is_error' => $_GET['is_error'],
            'message'=>$_GET['message'],
            'categories'=>$categoriesDataresult,
            'countries'=>$countriesDataresult,
            'states'=>$statesDataresult,
            'cities'=>$citiesDataresult,
            'user_role'=>$loginUserRole,
            'server_error'=>$server_error
        ];
     // Render our view
 echo $twig->render('/products/product-add.html.twig',$parameters);
