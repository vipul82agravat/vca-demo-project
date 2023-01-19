<?php
namespace Helper\Master;

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
            public function UpdateDetails($table,$data,$id){
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

        public function DeleteDetails($table,$id){

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
         public function employeeCheckInOutStatus($table){
            try {
               // session_start();
               $user_id=$_SESSION['user_id'];
               $date=date('y-m-d');
               $data="`emp_id` = ".$user_id." AND `emp_date` = '".$date."'";

               $response= $this->sqlconnection();
               $this->connection=$response['connection'];
               $connection=$this->connection;

              $query='SELECT * FROM '.$table.' WHERE '.$data;

                    $res=mysqli_query($connection,$query);

//

                    if (mysqli_num_rows($res) == 0) {
                        $row = mysqli_fetch_assoc($res);

                        $type='checkin';
                        $arr=['status'=>1,
                                'message'=>'Check In Successfully',
                                'data'=>$type,
                            ];


                    }else if(mysqli_num_rows($res)==1 and mysqli_num_rows($res) < 2){
                        $type='checkout';

                        $arr=['status'=>1,
                                'message'=>'Check Out Successfully',
                                'data'=>$type,
                            ];

                    }else{
                         $arr=['status'=>0,
                                'message'=>'Already checkout',
                                'data'=>$type,
                            ];
                    }
                    return $arr;

            }
            catch(Exception $e){
                return $e.'mysql_error';

            }
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
    }
?>
