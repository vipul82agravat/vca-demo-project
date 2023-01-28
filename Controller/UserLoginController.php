<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../Helper/HelperClass.php');

class UserLoginController extends Helpercls {

        /*
        name of table for get userRegistration Details
        */
      public $table='users';
      public $username;

      /*@return
       *Check the user login details if available then use is able to login
       * access the admin panel other wise redirct to login page again
       */
      public function userLogin(){

        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $username=$email;
        $this->username=$username;
        $data="WHERE  email='$username'
                     AND password='" . $password . "'";
         return $data;

      }

}
      $userLogin = new UserLoginController;
      $table=$userLogin->table;
      $data=$userLogin->userLogin();

        /*
        * call the helper class login method for user details check in table
        * $table - name of the table which store the records
        * $data - data clounm and values string get form submit in login  form
        * this data will check on table using login method
        * response
        *  it will return the response when given parameters
        *  status 1 it means Login Save Successfully'
        *  status 0 it means  Not able to Login'
        */
      $userLoginresponse=$userLogin->login($table,$data);

      $responseData=$userLoginresponse['data'];

        if (mysqli_num_rows($responseData) > 0) {
            session_start();
             $token = bin2hex(random_bytes(16));
             $_SESSION['username'] = $_POST['email'];
             $_SESSION['token'] = $token;

                  if (mysqli_num_rows($responseData) > 0) {
                        $row = mysqli_fetch_assoc($responseData);
                        if($row['status']==0){
                            header('Location:../views/users/user-login.php?is_error=1&message=You need to Active You Account First Please check you Mail Box');
                            exit;
                        }
                        $username=$row['name'];
                        $id=$row['id'];
                        $_SESSION['user_id'] = $id;
                        $_SESSION['username'] = $username;

                  }

                  $tokendata="auth_token =  '".$token."'";

                    /*
                    * when user is try to loign with details at that time  updateUserSessionToken method is update the user session token in user table
                    * $table - tabe name to process the data
                    * $tokendata - it string for auth token information this detail will update
                    * $id - this login user id so function check this token  for which user and update token in table
                    * this funcion call shen user is try to login
                    */
                  $tokenResponse=$userLogin->updateUserSessionToken($table,$tokendata,$id);

             header('Location:../views/users/user-dashboard.php?is_error=0&message=Welcome User '.$username);

        }
        else{
              header('Location:../views/users/user-login.php?is_error=1&message=Login Details  are not Match Please Create Account First..');
        }



