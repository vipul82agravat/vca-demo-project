<?php
     session_start();
     if(isset($_SESSION['username']) and $_SESSION['username']!=null){

          $id=$_SESSION['user_id'];
          $getDetails =new Mastercls;
          $table='employee_registration';
          $tokendata="auth_token = ' '";
//           $getResponse=$getDetails->UpdateSessionTokenData($table,$tokendata,$id);

          session_destroy();
          header("Location: ../views/login.php");
          exit();

    }
     header("Location: ../views/user-login.php");
?>
