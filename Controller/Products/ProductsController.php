<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

class ProductsController extends Helpercls {

    /*
    name of table for save userRegistration Details
     */
    public $table='products';

    /*
     productsQueryData Details  return the string  for data value and clounm list for save products Details
    */
    public function productsQueryData(){


        $this->formValidation();
        session_start();
        $fileName = basename($_FILES["product_img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imgContent ='';

        $uploads_dir =$_SERVER['DOCUMENT_ROOT']."/public/products/";
        $fileDestination = $uploads_dir.$fileName;
        //echo $fileDestination;exit;
        if(in_array($fileType, $allowTypes)){
            $tmp_name = $_FILES['product_img']['tmp_name'];
            $imgContent = "";//addslashes(file_get_contents($tmp_name));
            move_uploaded_file($tmp_name,$fileDestination);
        }
        $category_id=$_POST['product_category'];
        $title=$_POST['product_title'];
        $user_id=$_SESSION['user_id'];
        $location=$_POST['product_location'];
        $countries=$_POST['countries'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $status=$_POST['product_status'];
        $postcode=$_POST['postcode'];
        $product_compnay=$_POST['product_compnay'];
        $address=$_POST['product_address'];
        $description=$_POST['product_description'];

        $column='title,img,img_path,category_id,location,countries_id,state_id,city_id,postcode,company_name,description,address,user_id,status';
        $data="'".$title."','".$imgContent."','".$fileName."','".$category_id."','".$location."','".$countries."','".$state."','".$city."','".$postcode."','".$product_compnay."','".$description."','".$address."','".$user_id."','".$status."'";

        $productsDetails=['column'=>$column,
            'values'=>$data];

        return $productsDetails;

    }

     /*
     productsUpdateQueryData Details return the string  for data value and clounm list for update products Details
    */
    public function productsUpdateQueryData(){

        //$this->formValidation();

        $fileName = basename($_FILES["product_img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imgContent ='';

        $uploads_dir =$_SERVER['DOCUMENT_ROOT']."/public/images/products/";
        $fileDestination = $uploads_dir.$fileName;
        if($fileName!=""){
            if(in_array($fileType, $allowTypes)){
                $tmp_name = $_FILES['product_img']['tmp_name'];
                $imgContent = "";//addslashes(file_get_contents($tmp_name));
                move_uploaded_file($tmp_name,$fileDestination);
            }
        }

        $category_id=$_POST['product_category'];
        $title=$_POST['product_title'];
        $user_id=$_SESSION['user_id'];
        $location=$_POST['product_location'];
        $countries=$_POST['countries'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $status=$_POST['product_status'];
        $postcode=$_POST['postcode'];
        $product_compnay=$_POST['product_compnay'];
        $address=$_POST['product_address'];
        $description=$_POST['product_description'];

        if($fileName!="") {
            $dataQuery = "title = '" . $title . "', img = '" . $imgContent . "', img_path = '" . $fileName . "', category_id = '" . $category_id . "', location = '" . $location . "', countries_id = '" . $countries . "', state_id = '" . $state . "', city_id = '" . $city . "', address = '" . $address . "', status = '" . $status . "', postcode= '" . $postcode . "', company_name = '" . $product_compnay . "', description = '" . $description . "'";
        } else{
            $dataQuery="title = '".$title."', category_id = '".$category_id."', location = '".$location."', countries_id = '".$countries."', state_id = '".$state."', city_id = '".$city."', address = '".$address."', status = '".$status."', postcode= '".$postcode."', company_name = '".$product_compnay."', description = '".$description."'";
        }
        $categoryDetails=['dataQuery'=>$dataQuery];

        return $categoryDetails;

    }
    /*
    *formValidation is used to check the  require feild is not empty if it empty it return the back with error
    * error is shwoing to user requre feild must be not left blank
    */
    public  function  formValidation(){

        $category_id=$_POST['product_category'];
        $title=$_POST['product_title'];
        $location=$_POST['product_location'];
        $countries=$_POST['countries'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $status=$_POST['product_status'];

        $error_message=[];
        $is_error=0;

        if(empty($title)){
            $error_message[$is_error]="Please Enter Title";
            $is_error++;
        }
        if(empty($countries)){
            $error_message[$is_error]="Please Enter Countries";
            $is_error++;
        }
        if(empty($location)){
            $error_message[$is_error]="Please Enter Location";
            $is_error++;
        }
        if(empty($state)){
            $error_message[$is_error]="Please Enter State";
            $is_error++;
        }
        if(empty($city)){
            $error_message[$is_error]="Please Enter City";
            $is_error++;
        }

        if(empty($status)){
            $error_message[$is_error]="Please Enter Status";
            $is_error++;
        }
        if(empty($category_id)){
            $error_message[$is_error]="Please Enter Category";
            $is_error++;
        }

        if( $is_error >=1) {
            $error_string = implode(",", $error_message);
            header('Location:../../views/products/product-add.php?is_error=0&server_error='.$error_string);
            exit;
        }
        return true;

    }

}
    $productsObj = new ProductsController;
    $table=$productsObj->table;

    /*
     * check if product_id is set it at that time update record using productsUpdateQueryData
     */
    if(isset($_POST['product_id']) and $_POST['product_id']!=""){


        $id=$_POST['product_id'];
        $productUpdatedetails=$productsObj->productsUpdateQueryData();
        $dataQuery=$productUpdatedetails['dataQuery'];
        //echo  $dataQuery;exit;
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
        $productsUpdateResponse=$productsObj->update($table,$dataQuery,$id);

        if($productsUpdateResponse['status']==1){

            header('Location:../../views/products/product-index.php?is_error=0&message='.$productsUpdateResponse['message']);
        }else{
            header('Location:../../views/products/product-index.php?is_error=1&message='.$productsUpdateResponse['message']);
        }

        exit;

    }

    /*
     * chgeck the type in post request this means type of serach and call this form ajax request for search the product
     * $_POST['search_text']; get the string fors search_text the check the  getProductDetails with like condtion
     * return the result is found
     * return this html div  on ajax reponse and set in view page
     */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="serach"){

        $serach_text=$_POST['search_text'];
        $selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
        $data=" WHERE products.title LIKE '%$serach_text%'";

        $productsUpdateResponse=$productsObj->getProductDetails($data,$selectData);

        $html="Result Not Found...";
        if (mysqli_num_rows($productsUpdateResponse['data']) > 0) {

            $html='<div class="row product_list">';
            while ($row = mysqli_fetch_array($productsUpdateResponse['data'])) {

                    $title=$row['title'];
                    $img_path=$row['img_path'];
                    $id=$row['product_id'];
                    $catgory_name=$row['catgory_name'];
                    $state=$row['states_name'];
                    $city=$row['city_name'];
                    $postcode=$row['postcode'];
                    $company_name=$row['company_name'];
                    $address=$row['address'];
                    $description=$row['description'];
                    $img_path=$row['img_path'];
                    $image=$row['image'];
//
                $html.='
                <div class="col-sm-7"><img class="img-thumbnail" src="http://vca.demoproject.aum/public/images/products/'.$img_path.'" alt="user avatar"></div>
                <div class="col-sm-5"><h3>'.$title.'</h3>
                    <p class="w3-opacity">Company Name:: '.$catgory_name.'</p>
                    <p>Description::'.$description.'</p>
                    <p>Address::'.$address.'-'.$state.'-'.$city.'-'.$postcode.'</p>
                    <a href="user-products-view.php?id='.$id.'" id="create" class="btn btn-primary" target="_blank">ViewDetails</a></div>
                <hr>
                ';
            }
            $html.="</div><hr>";
        }

        echo $html;
        exit;
    }
    /*
    * check the type in post request this means type of product_date_filter and call this serach the products
    *check the data ne between start and end date
    * return the result is found
    * if recrods is found at that time crate  products details
    */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="product_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/products/product-index.php?start_date='.$start_date.'&end_date='.$end_date);
        exit;
    }

    $productdetails=$productsObj->productsQueryData();
    $values=$productdetails['values'];
    $column=$productdetails['column'];

    /*
    * call the helper class ShowDetails method for get the records in table
    * $table - name of the table which get the records
    *
    * response
    *  it will return the response when given parameters
    *  status 1 it means get Records  Successfully'
    *  status 0 it means  Records Not  Found...'
    */
    $id=Auth::AuthUserId();
    $data=" WHERE  user_id =".$id;
     /* check userRoleCheck  this function what is the role of given user id
     * it return the number or  id  of role
     * $id user id pass in mathod paramters
     */
    $loginUserRole=$productsObj->userRoleCheck(Auth::AuthUserId());
    /*Get the category data base on user condtion
    $id user login id it return all  user added category
    $table - name of table for get the category data
    $data the condition of get data base in user id
    */
    $productShowDataResponse=$productsObj->ShowConditionalBaseDetails($table,$data);
    if($productShowDataResponse['status']==1){

        $countProducts=mysqli_num_rows($productShowDataResponse['data']);
        if($countProducts >=3 and $loginUserRole!=1){

            header('Location:../../views/products/product-index.php?is_error=1&message=Add Product Limit is Reached  Please contact to Admin...');
        }else{

            $productStoreResponse=$productsObj->store($table,$column,$values);

            if($productStoreResponse['status']==1){

                header('Location:../../views/products/product-index.php?is_error=0&message='.$productStoreResponse['message']);
            }else{
                header('Location:../../views/products/product-index.php?is_error=1&message='.$productStoreResponse['message']);
            }

        }
    }

?>
