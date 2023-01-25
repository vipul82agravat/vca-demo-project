<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../Helper/HelperClass.php');


class UserRegisterController extends Helpercls{

    /*
    name of table for save userRegistration Details
     */
    public $table='users';

    /*
     userRegistration Details  return the string  for data value and clounm list for user Registration Details
    */
    public function userRegistration(){

        $fname=$_POST['name'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $permission='{"role":"admin"}';
        $column='name,email,password,permission';
        $data="'".$fname."','".$email."','".$password."','".$permission."'";
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

    /*
     * this userUpdateQueryDetails is  user to return the update query string
     * and return the details of update data
     * set the new value in table base on this string return
     */
    public function userUpdateQueryDetails(){

        $name=$_POST['name'];
        $status=$_POST['status'];

        $dataQuery="name = '".$name."', status = '".$status."'";

        $userDetails=['dataQuery'=>$dataQuery];

        return $userDetails;

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

    /*
     * this block is call when try to upate user information
     * this block is check is user id is there then call the update userUpdateQueryDetails  function to get the query
     *  retuirn the query   stting and pass to update the process
     * return reponse of update user data in table
     */
    if(isset($_POST['user_id']) and $_POST['user_id']!=""){
        $id=$_POST['user_id'];
        $useuUpdaterQuery=$UserRegister->userUpdateQueryDetails();
        $dataQuery=$useuUpdaterQuery['dataQuery'];

        /*
       * call the helper class Update method for update the records in table
       * $table - name of the table which store the records
       * $dataQuery - update Query form submit
       *
       * response
       *  it will return the response when given parameters
       *  status 1 it means Records Update Successfully'
       *  status 0 it means  Records Not Update Successfully'
       */
        $userUpdateResponse=$UserRegister->update($table,$dataQuery,$id);


        if($userUpdateResponse['status']==1){

            if(isset($_POST['role_id']) and $_POST['role_id']!=""){

                $table='role_users';
                $data=' WHERE user_id ='.$_POST['user_id'];

                /*Get the category data base on user auth data
                $id user login id it return all  user added category
                $table - name of table for get the category data
                $data the condition of get data base in user id
                */
                $userRoleDetails=$UserRegister->ShowConditionalBaseDetails($table,$data);
                if (mysqli_num_rows($userRoleDetails['data']) >= 0) {

                    $row = mysqli_fetch_assoc($userRoleDetails['data']);
                    $id=$row['id'];
                    $dataQuery="role_id = '".$_POST['role_id']."'";
                    $userRoleUpdateResponse=$UserRegister->update($table,$dataQuery,$id);

                }else{

                    $role_column='user_id,role_id';
                    $role_values="'".$_POST['user_id']."','".$_POST['role_id']."'";

                    $roleUpdateRegisterResponse=$UserRegister->store($table,$role_column,$role_values);
                }
            }
            $loginUserRole=$UserRegister->userRoleCheck(Auth::AuthUserId());
            if($loginUserRole==1){
            header('Location:../../views/users/user-index.php?message='.$userUpdateResponse['message']);
            }else{
                header('Location:../../views/users/user-dashboard.php?message='.$userUpdateResponse['message']);
            }
        }else{
            header('Location:../../views/users/user-index.php?message='.$userUpdateResponse['message']);
        }

        exit;
    }

    $Registrationdetails=$UserRegister->userRegistration();
    $values=$Registrationdetails['values'];
    $column=$Registrationdetails['column'];
    /*
    * chgeck the type in post request this means type of serach and call this form ajax request for serach the prodcut
    * $_POST['serach_text']; get the string fors serach the check the  getProductDetails with like condtion
    * return the result is found
    * if recrods is found at that time crate html div in loop and greate the final html code
    * and return this code on ajax reponse and set in view page
    */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="user_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/users/user-index.php?start_date='.$start_date.'&end_date='.$end_date);
        exit;
    }
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
            $links="http://vca.demoproject.aum/views/users/user-dashboard?user-data=".$userdata;
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
