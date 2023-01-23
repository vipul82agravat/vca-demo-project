<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

class ProductsController extends Helpercls {

    /*
    name of table for save userRegistration Details
     */
    public $table='products';

    /*
     productsQueryData Details  return the string  for data value and clounm list for save category Details
    */
    public function productsQueryData(){
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
            $imgContent = addslashes(file_get_contents($tmp_name));
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

        $column='title,img,img_path,category_id,location,countries,state,city,postcode,company_name,description,address,user_id,status';
        $data="'".$title."','".$imgContent."','".$fileName."','".$category_id."','".$location."','".$countries."','".$state."','".$city."','".$postcode."','".$product_compnay."','".$description."','".$address."','".$user_id."','".$status."'";

        $productsDetails=['column'=>$column,
            'values'=>$data];

        return $productsDetails;

    }
     /*
     productsUpdateQueryData Details  return the string  for data value and clounm list for update products Details
    */
    public function productsUpdateQueryData(){

        $fileName = basename($_FILES["product_img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imgContent ='';

        $uploads_dir =$_SERVER['DOCUMENT_ROOT']."/public/products/";
        $fileDestination = $uploads_dir.$fileName;
        //echo $fileDestination;exit;
        if(in_array($fileType, $allowTypes)){
            $tmp_name = $_FILES['product_img']['tmp_name'];
            $imgContent = addslashes(file_get_contents($tmp_name));
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

        $dataQuery="title = '".$title."', img = '".$imgContent."', img_path = '".$fileName."', category_id = '".$category_id."', location = '".$location."', countries = '".$countries."', state = '".$state."', city = '".$city."', address = '".$address."', status = '".$status."', postcode= '".$postcode."', company_name = '".$product_compnay."', description = '".$description."'";

        $categoryDetails=['dataQuery'=>$dataQuery];

        return $categoryDetails;

    }

}

    $ProductsObj = new ProductsController;
    $table=$ProductsObj->table;

    if(isset($_POST['product_id']) and $_POST['product_id']!=""){

        $id=$_POST['product_id'];
        $ProductUpdatedetails=$ProductsObj->productsUpdateQueryData();
        $dataQuery=$ProductUpdatedetails['dataQuery'];

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
        $ProductsUpdateResponse=$ProductsObj->update($table,$dataQuery,$id);

        if($ProductsUpdateResponse['status']==1){

            header('Location:../../views/products/product-index.php?message='.$ProductsUpdateResponse['message']);
        }else{
            header('Location:../../views/products/product-index.php?message='.$ProductsUpdateResponse['message']);
        }

        exit;

    }
    //print_r($_POST);EXIT;
    $Productdetails=$ProductsObj->productsQueryData();
    $values=$Productdetails['values'];
    $column=$Productdetails['column'];

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
    $ProductShowDataResponse=$ProductsObj->ShowDetails($table);

    if($ProductShowDataResponse['status']==1){

        $countProducts=mysqli_num_rows($ProductShowDataResponse['data']);
        if($countProducts >=3){

            header('Location:../../views/products/product-index.php?message=Add Product Limit is Reached  Please contact to Admin...');
        }else{
            $ProductStoreResponse=$ProductsObj->store($table,$column,$values);

            if($CategoryStoreResponse['status']==1){

                header('Location:../../views/products/product-index.php?message='.$ProductStoreResponse['message']);
            }else{
                header('Location:../../views/products/product-index.php?message='.$ProductStoreResponse['message']);
            }

        }
    }

?>
