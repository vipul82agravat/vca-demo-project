<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../Helper/HelperClass.php');


    class UserForgetPassowrdController extends Helpercls{

        /*
        name of table for save token Details for pasword reset
         */
        public $table='password_reset_temp';

        /*
         * userPasswrodResertDetails methos is used to set the value and clounm list for store password reset tamp table for fetaure refrance to match with key
         */
        public function userPasswrodResertDetails(){

            $email=$_POST['email'];
            $token = bin2hex(random_bytes(16));
            $date= date("Y-m-d", strtotime("+ 1 day"));
            $column='email,token,expDate';
            $data="'".$email."','".$token."','".$date."'";
            $userpassDetails=['column'=>$column,
                                   'values'=>$data,
                                   'token'=>$token,
                                    'email'=>$email];

            return $userpassDetails;

        }


    }
        $UserForgetPassword = new UserForgetPassowrdController;
        $table=$UserForgetPassword->table;
        $PasswrodResertDetails=$UserForgetPassword->userPasswrodResertDetails();
        $values=$PasswrodResertDetails['values'];
        $column=$PasswrodResertDetails['column'];
        $token=$PasswrodResertDetails['token'];
        $email=$PasswrodResertDetails['email'];


        /*
        * call the helper class Store method for save the records in table
        * $table - name of the table which store the records
        * $data - data values get form submit in registration form
        * $clounm -is set the clounm name of table which insert the records base on clounm
        *
        * response
        *  it will return the response when given parameters
        *  status 1 it means Records Save Successfully'
        *  status 0 it means  Records Not Save Successfully'
        */

        $UserForgetPasswordResponse=$UserForgetPassword->store($table,$column,$values);

        if($UserForgetPasswordResponse['status']==1){

                $userdata='token='.$token.'&email='.$email;
                $userdata=base64_encode($userdata);
                $links="http://vca.demoproject.aum/views/users/user-password-reset.php?user-data=".$userdata;
                $subject="Forget passoword Links";
                $message="
                    <html>
                    <head>
                    <title>User Password Reset email</title>
                    </head>
                    <body>
                    <p>Hi $email,</p>
            
                    <p>There was a request to change your password!</p>
            
                    <p>If you did not make this request then please ignore this email.</p>
            
                    <p>Otherwise, please click this link to change your password: <a href='$links'>ResetPassword</a></p>
                   </body>
                    </html>
                    ";


                 /*
                *sendMail  is used to send the mail to the user to helper class function to send mathod
                * $email -email address to send the mail
                * $name -name of user to send the mail
                * $sbject -set the subject of mail send  lile password resert,account created etc.....
                * $message -it body contect of mail to send to the user to action perpose
                */
                $ForgetPasswordEamilResponse=$UserForgetPassword->sendMail($email,$name,$message,$subject);

                if($ForgetPasswordEamilResponse['status']==1){
                    header('Location:../views/users/user-registration.php?message='.$ForgetPasswordEamilResponse['message']);
                }else{
                    header('Location:../views/users/user-registration.php?message='.$ForgetPasswordEamilResponse['message']);
                }
        }else{
            header('Location:../views/users/user-forgot-password.php?message=Something Went Wrong');
        }


?>
