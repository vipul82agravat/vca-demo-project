<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

     session_start();
     if(isset($_SESSION['username']) and $_SESSION['username']!=null){

          $id=$_SESSION['user_id'];

           $getDetails =new Helpercls;
           $table='users';
           $tokendata="auth_token = ' '";
           $getResponse=$getDetails->updateUserSessionToken($table,$tokendata,$id);

          session_destroy();
          header("Location: ../users/user-login.php");
          exit();

    }
     header("Location: ../users/user-login.php");
?>
