<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../Helper/HelperClass.php');


class UserRegisterController extends Helpercls{

    /*
    name of table for save userRegistration Details
     */
    public $table='users';

    /*
     userRegistration Details  return the string  for data value and clounm list for save Registration Details
    */
    public function userRegistration(){

        $fname=$_POST['full_name'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $column='name,email,password';
        $data="'".$fname."','".$email."','".$password."'";
        $registrationDetails=['column'=>$column,
            'values'=>$data];

        return $registrationDetails;

    }
    /*
     userEmailCheck  return the string  of email value and clounm list for check the email extis or not when user Registration
    */
    public function userEmailCheck(){

        $email=$_POST['emailId'];
        $useremaildata="WHERE email='$email'";
        return $useremaildata;
    }


}
    $UserRegister = new UserRegisterController;
    $table=$UserRegister->table;

    /*
     * ajax email checking or validation if type found
     */
    if(isset($_POST['type']) and $_POST['type']=='emailcheck'){

        $userEmailDetails=$UserRegister->userEmailCheck();
        /*
        userEmailExists   return the respnose is user email is already exists or not
        return stastus 1 already exists
        status 0 not already exists
        */
        $reponseEmailcheck=$UserRegister->userEmailExists($table,$userEmailDetails);
        if($reponseEmailcheck['status']==1){
           echo  $reponseEmailcheck['status']; exit;
        }else{
            echo  0; exit;
        }
    }


    $Registrationdetails=$UserRegister->userRegistration();
    $values=$Registrationdetails['values'];
    $column=$Registrationdetails['column'];

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

    $UserRegisterResponse=$UserRegister->store($table,$column,$values);
    if($UserRegisterResponse['status']==1){
            $email=$_POST['email'];
            $userdata='type=Active&email='.$email;
            $userdata=base64_encode($userdata);
            $links="http://vca.demoproject.aum/views/users/user-index?user-data=".$userdata;
            $subject="User confirmation email For activate the account";
            $message="
                    <html>
                    <head>
                    <title>User Password Reset email</title>
                    </head>
                    <body>
                    <p>Hello $email,</p>
            
                    <p>Thank you for joining [VCA DEMO].</p>
            
                    <p>We’d like to confirm that your account was created successfully. To access [VCA DEMO] click the link below.</p>
                     <p><a href='$links'>Active Account</a></p>
                    <p>If you experience any issues logging into your account, reach out to us at [vca@demo.com].</p>
                    <p>Best,</p>
                    <p>The [VCA DEMO] team</p>
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
        $userRegisterEamilResponse=$UserRegister->sendMail($email,$name,$message,$subject);
        header('Location:../views/users/user-index.php?message='.$UserRegisterResponse['message']);
    }else{
        header('Location:../views/users/user-registration.php?message='.$UserRegisterResponse['message']);
    }


?>
