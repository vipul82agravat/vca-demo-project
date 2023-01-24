<?php
namespace Helper\Master;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

define('HOST','localhost');
define('USER_NAME','newuser');
define('USER_PASSWORD','password');
define('DATABASE','demoproject');


class HelperClass {

        public $connection;
        public $status;

        function __construct(){

            //session_start();
            /* when call the Hleper class object it will call __construct method mane make it database connection with details
             user name,password,databsse name and make the connection for some table related activity
             */
           $response= $this->sqlconnection();
           $this->connection=$response['connection'];
           $this->status=$response['status'];

            if($this->status!=1){
                echo "DB Connection issuse please check congration details for connection";exit;
            }
        }
        /*
         * Check the user login details  form given parameters if available or not check and return the respons
         * $table - name of the table which store the records
         * $data - data clounm and values string get form submit in login  form
         * this data will check on table using login method if user details is true then it able access the admin panel other wise redirect to login page again
         * retry with correct email and password in login page
         */
        public function login($table,$data){
            try{

            $connection=$this->connection;

            $query    = "SELECT * FROM `$table` ".$data;
            $loginResponse=mysqli_query($connection,$query);

            return $arrayLoginResponse=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$loginResponse,
                        ];

            }
            catch(Exception $e){
                return $e."error on get details form table ".$table;
            }
        }
        public function ShowDetails($table){
            try{
            $connection=$this->connection;
            $query='SELECT * FROM '.$table;
            $res=mysqli_query($connection,$query);

            return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }
            catch(Exception $e){
                return $e."error on save time";
            }
        }
        public function ShowIdBaseDetails($table,$id){
            try{
            $connection=$this->connection;
            $query='SELECT * FROM '.$table.' WHERE id='.$id;
            $res=mysqli_query($connection,$query);

            return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }
            catch(Exception $e){
                return $e."error on save time";
            }
        }
        /*
         * ShowConditionalBaseDetails is used to get the data base Conditional like user_id=1, name = test etc...
         * $table - name og table to get the data form table
         * $data is set the Condition when call this function
         * process data base on Condition and given the response
         */
        public function ShowConditionalBaseDetails($table,$data){
            try{

                $connection=$this->connection;
                $query='SELECT * FROM '.$table. $data;
                $res=mysqli_query($connection,$query);

                return $arr=['status'=>1,
                    'message'=>'Records List Successfully',
                    'data'=>$res,
                ];

            }
            catch(Exception $e){
                return $e."error on save time";
            }
        }
        /*
         * Helper Store method use to  save the records base on clounm,values and tabe name in databse table
         *  $table - name of the table which store the records
         * $data - data values get form submit in registration form
         * $clounm -is set the clounm name of table which insert the records base on clounm
         */
        public function store($table,$column,$values){

            try{

                $connection=$this->connection;

                $query='INSERT INTO '.$table.' ('.$column.') VALUES ('.$values.')';
                $save=mysqli_query($connection,$query);
                if($save){
                return $arr=['status'=>1,
                        'message'=>'Records Save Successfully'
                        ];
                }
                else{
                    return $arr=['status'=>0,
                        'message'=>'Something Went Wrong'
                    ];
                }

            }
            catch(Exception $e){
                return $e."error on insterting table->".$table;
            }
        }
        /* @return
        userEmailExists   return the respnose is user email is already exists or not
        return stastus 1 already exists
        status 0 not already exists
        */
        public function userEmailExists($table,$data){
            try{
                $connection=$this->connection;
                $query='SELECT * FROM '.$table.' '.$data;

                $responseData=mysqli_query($connection,$query);

                if (mysqli_num_rows($responseData) > 0) {
                    return $arr=['status'=>1,
                        'message'=>'Email is  Already Exists',
                        'data'=>$responseData,
                    ];
                }else{
                    return $arr=['status'=>0,
                        'message'=>'Email is  Not Exists',
                        'data'=>$responseData,
                    ];
                }

            }
            catch(Exception $e){
                return $e."error on save time";
            }
        }
        public function update($table,$data,$id){
            try{

                $response= $this->sqlconnection();
                $this->connection=$response['connection'];
                $connection=$this->connection;

                $query='UPDATE '.$table.' SET '. $data .'  WHERE id='.$id;

                $save=mysqli_query($connection,$query);

                return $arr=['status'=>1,
                            'message'=>'Records Updated Successfully'
                            ];

            }
            catch(Exception $e){
                return $e."error on update time";
            }
        }
        public function passwordUpdate($table,$data,$condition){
            try{

                $response= $this->sqlconnection();
                $this->connection=$response['connection'];
                $connection=$this->connection;

                $query='UPDATE '.$table.' SET '. $data .'  WHERE '.$condition;
                $update=mysqli_query($connection,$query);

                if($update){
                    return $arr=['status'=>1,
                        'message'=>'Records Updated Successfully'
                    ];
                }else{
                    return $arr=['status'=>0,
                    'message'=>'Records is not Updated'
                ];
                }

            }
            catch(Exception $e){
                return $e."error on update time";
            }
        }
        /*
        *  delete is used ti delete dataform table
        *  $table name of table you wont to delete data
        * $id which records you need to delete set the recotds id
        *  return the response of delete records
        *  1 delete susscfully
        * 0 Not delete
        */
        public function delete($table,$id){

            try{

                $response= $this->sqlconnection();
                $this->connection=$response['connection'];
                $connection=$this->connection;

                $query='DELETE  FROM '.$table.' WHERE id='.$id;

                $delete=mysqli_query($connection,$query);

                return $arr=['status'=>1,
                            'message'=>'Records Delete Successfully'
                            ];

            }
            catch(Exception $e){
                return $e."error on delete time";
            }
        }
        /* when call the sqlconnection method it will call __construct time method make it database connection with details
          user name,password,databsse name and make the connection for some table related activity
          return the status code and connection details is connection is successfully
         */
        public function sqlconnection(){
            try {

                $conn = mysqli_connect(HOST, USER_NAME,USER_PASSWORD,DATABASE);
                if(! $conn ) {
                    die('Could not connect: ' . mysql_error());
                }
                $arr=[
                    'status'=>'1',
                    'connection'=>$conn
                    ];

                return $arr;
            }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        /*
         * when user is try to loign with details at that time  updateUserSessionToken method is update the user session token in user table
         * $table - tabe name to process the data
         * $data - it string for auth token information this detail will update
         * $id - this login user id so function check this token  for which user and update token in table
         * this funcion call shen user is try to login
         */
        public function updateUserSessionToken($table,$data,$id){
            try{

                $connection=$this->connection;
                $query='UPDATE '.$table.' SET '. $data .'  WHERE id='.$id;
                $update=mysqli_query($connection,$query);
                if($update){
                    return $arr=['status'=>1,
                            'message'=>'Token Updated Successfully'
                            ];
                }else{
                    return $arr=['status'=>0,
                        'message'=>'Token is not Updated'
                    ];
                }

            }
            catch(Exception $e){
                return $e."error on update time";
            }
        }
        /*
         * verifyAuthUserToken method is chekck access the page before validate the user is authorized or not
         * if user is not authorized then it will redirect to login page
         * if user is valid and authorized then it will access the admin panel
         */
        public  function verifyAuthUserToken(){
            try{
                session_start();

                $response= $this->sqlconnection();
                $this->connection=$response['connection'];
                $connection=$this->connection;

                $auth_token=isset($_SESSION['token']) ? $_SESSION['token'] : null;
                $user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null ;
                $table='users';

                if($auth_token!=null and $auth_token!=null){
                    $data="id ='".$user_id."' AND auth_token = '".$auth_token."'";
                    $query='SELECT * FROM '.$table.' WHERE '.$data;

                    $res=mysqli_query($connection,$query);
//
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);

                        return $arr=['status'=>1,
                                'message'=>'Auth  verify Successfully',
                                'data'=>$res,
                            ];

                    }else{
                         return $arr=['status'=>0,
                                'message'=>'Auth  exipre or Auth  verify ',
                                'data'=>$res,
                            ];
                    }
               }else{

                    header("Location: user-login.php?message=Must be Login first");
                    exit();
                }


            }
            catch(Exception $e){
                return $e."error on update time";
            }
        }
         public function resetPasswordLinksStatus($email,$token){

            try {
               // session_start();
                $table="password_reset_temp";
               $date=date('y-m-d');

               $data="`email` = '".$email."'AND `expDate` >= '".$date."' AND `token` = '".$token."'";

               $response= $this->sqlconnection();
               $this->connection=$response['connection'];
               $connection=$this->connection;

              $query='SELECT * FROM '.$table.' WHERE '.$data;

                    $passwordTmpResponse=mysqli_query($connection,$query);

//

                    if (mysqli_num_rows($passwordTmpResponse) == 0) {

                        $passworLinksarr=['status'=>0,
                                'message'=>'Token is not match with this user',
                                ];


                    }else if(mysqli_num_rows($passwordTmpResponse) > 0 ){

                            $passworLinksarr=['status'=>1,
                                'message'=>'User Request Found Successfully',
                            ];

                    }
                   return $passworLinksarr;

            }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        /*
        * check userRoleCheck  this function what is the role of given user id
        * it return the number or  id  of role
        * $id user id pass in mathod paramters
         * return the id of user defuul id set as 2, 2= admin
        */
        public  function  userRoleCheck($id){

                $table='role_users';
                $data=' WHERE user_id ='.$id;

                /*Get the category data base on user auth data
                $id user login id it return all  user added category
                $table - name of table for get the category data
                $data the condition of get data base in user id
                */
                $getUserData=$this->ShowConditionalBaseDetails($table,$data);
                $role_id=2;
                if (mysqli_num_rows($getUserData['data']) > 0) {
                    $row = mysqli_fetch_assoc($getUserData['data']);
                    $role_id=$row['role_id'];

                }
                return $role_id;

        }
        public function leftJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData){
            try {

            $connection=$this->connection;
            $query='SELECT '.$selectData.' FROM '.$table1.' LEFT JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
//             $query='SELECT * FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
            $res=mysqli_query($connection,$query);
            if(mysqli_num_rows($res) >1 ){

               return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }else{

            return $arr=['status'=>0,
                        'message'=>'Records Not Found',
                        'data'=>$res,
                        ];

            }


        }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }

        public function rightJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData){
            try {

            $connection=$this->connection;
            $query='SELECT '.$selectData.' FROM '.$table1.' RIGHT JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
//             $query='SELECT * FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
            $res=mysqli_query($connection,$query);
            if(mysqli_num_rows($res) >1 ){

               return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }else{

            return $arr=['status'=>0,
                        'message'=>'Records Not Found',
                        'data'=>$res,
                        ];

            }


        }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        /*
         * getProductDetails function used to get the product details with join data base on category,state,city
         * $data pass and where condidtion if require
         * $selectData select clounm list in response it pass alias name
         * it return the resonsedata base on all three table
         */
        public function getProductDetails($data,$selectData){
        try {

            $connection=$this->connection;
            $query="SELECT $selectData FROM `categories` RIGHT JOIN  products ON products.category_id=categories.id LEFT JOIN  states ON products.state=states.id LEFT JOIN  cities ON products.city=cities.id".$data;
            $res=mysqli_query($connection,$query);
            if(mysqli_num_rows($res) >1 ){

                return $arr=['status'=>1,
                    'message'=>'Records List Successfully',
                    'data'=>$res,
                ];

            }else{

                return $arr=['status'=>0,
                    'message'=>'Records Not Found',
                    'data'=>$res,
                ];

            }


        }
        catch(Exception $e){
            return $e.'mysql_error';

        }
    }
        public function crossJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData){
            try {

            $connection=$this->connection;
            $query='SELECT '.$selectData.' FROM '.$table1.' CROSS JOIN '.$table2;
//             $query='SELECT * FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
            $res=mysqli_query($connection,$query);
            if(mysqli_num_rows($res) >1 ){

               return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }else{

            return $arr=['status'=>0,
                        'message'=>'Records Not Found',
                        'data'=>$res,
                        ];

            }


        }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        public function InnerJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData){
            try {

            $connection=$this->connection;
            $query='SELECT '.$selectData.' FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
//             $query='SELECT * FROM '.$table1.' INNER JOIN '.$table2.' ON '.$table1.'.'.$tab1key.'='.$table2.'.'.$tab2key.' '.$data;
            $res=mysqli_query($connection,$query);
            if(mysqli_num_rows($res) >1 ){

               return $arr=['status'=>1,
                        'message'=>'Records List Successfully',
                        'data'=>$res,
                        ];

            }else{

            return $arr=['status'=>0,
                        'message'=>'Records Not Found',
                        'data'=>$res,
                        ];

            }


        }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        public function outerJoinData(){
            try {

               return true;
            }
            catch(Exception $e){
                return $e.'mysql_error';

            }
        }
        /*
         * Send mail for user mail address for event or activty
         */
        public function sendMail($email,$name,$message,$subject){
            //Create an instance; passing `true` enables exceptions

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = '4bcdff21785e96';                     //SMTP username
                $mail->Password   = '1a801316744641';                               //SMTP password
                $mail->SMTPSecure = 'TLS';//PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($email, 'Vca Demo');
                $mail->addAddress($email, $name);     //Add a recipient

                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = 'Mail Send';

                $mail->send();

                return $mailresponse=['status'=>1,
                                      'message'=>'Eamil Message has been sent'
                                     ];
            } catch (Exception $e) {
                //echo "Email Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
}
/*
 * create the new class for namesapce to access the  page to valid user
 * Authcheck function is check the user session is set id yes it valid and authorized
 * Authcheck function is check the user session is not set then  it not valid and  not authorized
 * user is not authorized it will redirect to login page  and rty to again login
 * this staic method call jist class name
 */

namespace Helper\Auth;

    class AuthCheck {

        static function AuthUser(){
            session_start();
            if(!isset($_SESSION['username']) and $_SESSION['username']==null){

                header("Location: user-login.php?message=Must be Login first");
                exit();

            }
        }
        /*
         * AuthUserId return current login user id  or auth user
         */
        static function AuthUserId(){
            session_start();
            if(isset($_SESSION['username']) and $_SESSION['user_id']!=null){

               return $_SESSION['user_id'];
            }
        }
        /*
       * AuthUserId return current login user id  or auth user
       */
        static function AuthRole(){
           return 1;
        }
    }
?>
