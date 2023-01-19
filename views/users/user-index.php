<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

/*
 * AuthUser method is chekck access the page before validate the Auth class have seesion is exits or nor
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
$check_auth = new Helpercls();
$check_auth->verifyAuthUserToken();


require_once __DIR__.'/bootstrap.php';

 $parameters = [
 'my_var' => 'Hello world !!!'
 ];


 // Render our view
 echo $twig->render('user-index.html.twig', $parameters);
