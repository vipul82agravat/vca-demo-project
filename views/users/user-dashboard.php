 <?php

use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$message="Welcome to Admin Protal.";
$status=1;
$is_error=0;


/*
 * Check if user is redirect form email links at that time user is inActive and not access to panel so first time is must be active the account form email links
 * check the user is valid
 * if user use valid so active the user and login to that account automatically login with user id
 *
 */
if(isset($_GET['user-data']) and $_GET['user-data']!=""){

    $userdata=base64_decode($_GET['user-data']);
    $userDetails=explode('&',$userdata);
    $type=explode('=',$userDetails[0])[1];
    $email=explode('=',$userDetails[1])[1];

    if($type=='Active'){

        $table="users";
        $data="WHERE email='".$email."'";

        $masterObject = new Helpercls();
        $checkEmailReponse=$masterObject->userEmailExists($table,$data);
        if($checkEmailReponse[status]==1){

            $row = mysqli_fetch_assoc($checkEmailReponse['data']);

                session_start();
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $username=$row['name'];
                $id=$row['id'];
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $status=1;
                $tokendata="status =  '".$status."', auth_token =  '".$token."'";
                $tokenResponse=$masterObject->updateUserSessionToken($table,$tokendata,$id);
                $message="Welcome to Admin Protal now your account is successfully activated.";
                $status=1;
                $is_error=0;
        }
    }

}
/*
 * AuthUser method is check access the page before validate the Auth user have seesion is exits or nor
 * if session is  not  extis then  is not authorized then it will redirect to login page
 * if user session is valid and authorized then it will access the admin panel
 * call the static class for checking
 */

    Auth::AuthUser();

    /*
     * verifyAuthUserToken method is chekck access the page before validate the user is authorized or not
     * it is validate the user id
     * * it is validate the user token
     * if user is not authorized then it will redirect to login page
     * if user is valid and authorized then it will access the admin panel
     */
    $masterObject = new Helpercls();
    $masterObject->verifyAuthUserToken();


    /*
    * userRoleCheck method is used to check login user role
    * like login user is admin.super-admin ,etc
    * it return role id
    */
    $loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());

    $userData=$masterObject->ShowDetails('users');
    $totalUser=mysqli_num_rows($userData['data']);


    $table='users';
    $status="'1'";
    $data=' WHERE status ='.$status;

    /*Get the User data base on user auth data
    $id user login id it return all  user added category
    $table - name of table for get the category data
    $data the condition of get data base in user id
    */
    $useActiverData=$masterObject->ShowConditionalBaseDetails($table,$data);
    $activeUser=mysqli_num_rows($useActiverData['data']);

    $status="'0'";
    $data=' WHERE status ='.$status;
     /* get All InActive User for admin user
    */
    $useInActiverData=$masterObject->ShowConditionalBaseDetails($table,$data);
    $inActiveUser=mysqli_num_rows($useInActiverData['data']);

    if($loginUserRole==1){
        $data="";

    }else{
        $id=Auth::AuthUserId();
        $data=' WHERE  user_id ='.$id;
    }
    /* get All product form admin user
    */
    $productData=$masterObject->ShowConditionalBaseDetails('products',$data);
    $totalProduct=mysqli_num_rows($productData['data']);

    $id=Auth::AuthUserId();
    $table='products';
    $status="'1'";
    if($loginUserRole==1){
        $data=' WHERE status='.$status;

    }else{
    $data=' WHERE status='.$status.' and user_id ='.$id;
    }
     /* get All Active product for admin user
    */
 $productActiverData=$masterObject->ShowConditionalBaseDetails($table,$data);
    $activeProduct=mysqli_num_rows($productActiverData['data']);

    $status="'0'";
    if($loginUserRole==1){
        $data=' WHERE status='.$status;

    }else{
        $data=' WHERE status='.$status.' and user_id ='.$id;
    }
     /* get All InActive product for admin user
    */
    $productInActiverData=$masterObject->ShowConditionalBaseDetails($table,$data);
    $inActiveProduct=mysqli_num_rows($productInActiverData['data']);


    $id=Auth::AuthUserId();
     /* get All  Users for admin user
    */
    $userShowData=$masterObject->ShowIdBaseDetails('users',$id);
    if (mysqli_num_rows($userShowData['data']) > 0) {
        $row = mysqli_fetch_assoc($userShowData['data']);
    }

    $loginUserRole=$masterObject->userRoleCheck(Auth::AuthUserId());
    $userRoleShowData=$masterObject->ShowIdBaseDetails('role',$loginUserRole);
    $role_name="";
    if (mysqli_num_rows($userRoleShowData['data']) > 0) {
        $role = mysqli_fetch_assoc($userRoleShowData['data']);
        $role_name=$role['name'];
    }

$parameters = [
    'is_error' => $_GET['is_error'],
    'message'=>($_GET['message'])  ? $_GET['message'] : 'Welcome to Admin Panel',
    'totalUser'=>$totalUser,
    'activeUser'=>$activeUser,
    'inActiveUser'=>$inActiveUser,
    'totalProduct'=>$totalProduct,
    'activeProduct'=>$activeProduct,
    'inActiveProduct'=>$inActiveProduct,
    'data'=>$row,
    'status'=>($row['status']==1) ? "Active" : "InActive",
    'role'=>$role_name,
    'user_role'=>$loginUserRole,
    'id'=>$id,
    'menu_status_dashboard'=>'active',

];

 // Render our view
 echo $twig->render('/users/user-dashboard.html.twig',$parameters);
