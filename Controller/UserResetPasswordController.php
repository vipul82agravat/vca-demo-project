<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../Helper/HelperClass.php');


    class UserResetPasswordController extends Helpercls{

        /*
        name of table for update password user tables or account password
         */
        public $table='users';

        /*
         userRegistration Details  return the string  for data value and clounm list for save Registration Details
        */
        public function userPasswordData(){


            $email=$_POST['email'];
            $password=md5($_POST['password']);
            $data="password =  '".$password."'";
            $NewPasswordDetails=['email'=>$email,
                'data'=>$data];
            return $NewPasswordDetails;

        }
    }
    $UserResetPassword = new UserResetPasswordController;
    $table=$UserResetPassword->table;

    $ResetPasswprdDetails=$UserResetPassword->userPasswordData();
    $email=$ResetPasswprdDetails['email'];
    $updateData=$ResetPasswprdDetails['data'];
    $conditionData="email='$email'";

    /*
     * call the helper class passwordUpdate method for update tthe password of user account
     * $table - name of the table which update the records
     * $data - update data string
     * $email -update password in which email
     *
     * response
     *  it will return the response when given parameters
     *  status 1 it means Records Update Successfully'
     *  status 0 it means  Records Not Update Successfully'
     */

$UserPasswordResetResponse=$UserResetPassword->passwordUpdate($table,$updateData,$conditionData);

    if($UserPasswordResetResponse['status']==1){
        header('Location:../views/users/user-index.php?message='.$UserRegisterResponse['message']);
    }else{
        header('Location:../views/users/user-login.php?message='.$UserRegisterResponse['message']);
    }


?>
