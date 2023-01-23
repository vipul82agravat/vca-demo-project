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

        $category_id=$_POST['category_id'];
        $title=$_POST['title'];
        $img='';//$_POST['img'];
        $user_id=1;
        $location=$_POST['location'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $status=$_POST['status'];
        $description=$_POST['description'];
        $column='title,category_id,location,state,city,description,address,user_id,status';
        $data="'".$title."','".$category_id."','".$location."','".$state."','".$city."','".$address."','".$status."','".$user_id."','".$description."'";

        $productsDetails=['column'=>$column,
            'values'=>$data];

        return $productsDetails;

    }
     /*
     productsUpdateQueryData Details  return the string  for data value and clounm list for update products Details
    */
    public function productsUpdateQueryData(){

        $category_id=$_POST['category_id'];
        $title=$_POST['title'];
        $img='';//$_POST['img'];
        $user_id=1;
        $location=$_POST['location'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $address=$_POST['address'];
        $status=$_POST['status'];
        $description=$_POST['description'];

        $dataQuery="title = '".$title."', category_id = '".$category_id."', location = '".$location."', state = '".$state."', city = '".$city."', address = '".$address."', status = '".$status."', description = '".$category_description."'";

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

            header('Location:../../views/products/products-index.php?message='.$ProductsUpdateResponse['message']);
        }else{
            header('Location:../../views/products/products-index.php?message='.$ProductsUpdateResponse['message']);
        }

        exit;

    }
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

    $CategoryStoreResponse=$ProductsObj->store($table,$column,$values);

    if($CategoryStoreResponse['status']==1){

        header('Location:../../views/products/products-index.php?message='.$CategoryStoreResponse['message']);
    }else{
        header('Location:../../views/products/products-registration.php?message='.$CategoryStoreResponse['message']);
    }


?>
