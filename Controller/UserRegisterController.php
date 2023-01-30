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

        $this->formValidation();

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

        $this->formValidation();

        $name=$_POST['name'];
        $status=$_POST['status'];

        $dataQuery="name = '".$name."', status = '".$status."'";

        $userDetails=['dataQuery'=>$dataQuery];

        return $userDetails;

    }
    /*
    *formValidation is used to check the  require feild is not empty if it empty it return the back with error
    * error is shwoing to user requre feild must be not left blank
    */
    public  function  formValidation(){

        $fname=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];


        $error_message=[];
        $is_error=0;

        if(empty($fname)){
            $error_message[$is_error]="Please Enter UserName";
            $is_error++;
        }
        if(empty($email)){
            $error_message[$is_error]="Please Enter Email";
            $is_error++;
        }
        if(!empty($email)){

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message[$is_error] = "Invalid email format";
            }

        }else{
            $error_message[$is_error]="Please Enter Password";
            $is_error++;
        }


        if( $is_error >=1) {
            $error_string = implode(",", $error_message);
            header('Location:../../views/users/user-registration.php?is_error=0&server_error='.$error_string);
            exit;
        }
        return true;

    }


}
    $userRegister = new UserRegisterController;
    $table=$userRegister->table;

    /*
     * ajax email checking or validation if type found
     */
    if(isset($_POST['type']) and $_POST['type']=='emailcheck'){

        $userEmailDetails=$userRegister->userEmailCheck();
        /*
        userEmailExists   return the respnose is user email is already exists or not
        return stastus 1 already exists
        status 0 not already exists
        */
        $reponseEmailcheck=$userRegister->userEmailExists($table,$userEmailDetails);
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
        $useuUpdaterQuery=$userRegister->userUpdateQueryDetails();
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
        $userUpdateResponse=$userRegister->update($table,$dataQuery,$id);


        if($userUpdateResponse['status']==1){

            if(isset($_POST['role_id']) and $_POST['role_id']!=""){

                $table='role_users';
                $data=' WHERE user_id ='.$_POST['user_id'];

                /*Get the role data base on user auth data
                $table - name of table for get the role data
                $data the condition of get data base in user id
                */
                $userRoleDetails=$userRegister->ShowConditionalBaseDetails($table,$data);

                if (mysqli_num_rows($userRoleDetails['data']) != 0) {

                    $row = mysqli_fetch_assoc($userRoleDetails['data']);
                    $id=$row['id'];
                    $dataQuery="role_id = '".$_POST['role_id']."'";

                    /*if role data match then i will update role in user_id*/

                    $userRoleUpdateResponse=$userRegister->update($table,$dataQuery,$id);

                }else{

                    /*if role data not match at hat time it add new records on role user table and set the role in user_id*/

                    $role_column='user_id,role_id';
                    $role_values="'".$_POST['user_id']."','".$_POST['role_id']."'";
                    $roleUpdateRegisterResponse=$userRegister->store($table,$role_column,$role_values);
                }
            }

            /*
            * userRoleCheck method is usd to check login user role
            * like login user is admin.super-admin ,etc
            * it return role id
            */
            $loginUserRole=$userRegister->userRoleCheck(Auth::AuthUserId());
            if($loginUserRole==1){
            header('Location:../../views/users/user-index.php?is_error=0&message='.$userUpdateResponse['message']);
            }else{
                header('Location:../../views/users/user-dashboard.php?is_error=0&message='.$userUpdateResponse['message']);
            }
        }else{
            header('Location:../../views/users/user-index.php?is_error=1&message='.$userUpdateResponse['message']);
        }

        exit;
    }
    /*
    * check the type in post request this means type of user_date_filter and call this serach the user
    *check the data ne between start and end date
    * return the result is found
    * if recrods is found at that time crate  users details
    */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="user_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/users/user-index.php?start_date='.$start_date.'&end_date='.$end_date);
        exit;
    }
    $Registrationdetails=$userRegister->userRegistration();
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

        $UserRegisterResponse=$userRegister->store($table,$column,$values);

        if($UserRegisterResponse['status']==1){



            $email=$_POST['email'];
            $userdata='type=Active&email='.$email;
            $userdata=base64_encode($userdata);
            $links="http://vca.demoproject.aum/views/users/user-dashboard?user-data=".$userdata;
            $subject="User confirmation email For activate the account";
            //html div for mail send in email
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
           *sendMail  is used to send the mail to the user to helper class function to sendMail method
           * $email -email address to send the mail
           * $name -name of user to send the mail
           * $subject -set the subject of mail send  lile password resert,account created etc.....
           * $message -it body contect of mail to send to the user to action perpose
           */
        $userRegisterEamilResponse=$userRegister->sendMail($email,$name,$message,$subject);
        header('Location:../views/users/user-index.php?is_error=0&message='.$userRegisterEamilResponse['message']);
        }else{
            header('Location:../views/users/user-registration.php?is_error=1&message='.$userRegisterEamilResponse['message']);
        }


?>
