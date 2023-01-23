<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

class CategoryController extends Helpercls {

    /*
    name of table for save userRegistration Details
     */
    public $table='categories';

    /*
     categoriesQueryData Details  return the string  for data value and clounm list for save category Details
    */
    public function categoriesQueryData(){

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $img='';//$_POST['img'];
        $user_id=1;
        $category_description=$_POST['category_description'];

        $column='name,status,user_id,description';
        $data="'".$category_name."','".$category_status."','".$user_id."','".$category_description."'";

        $categoryDetails=['column'=>$column,
            'values'=>$data];

        return $categoryDetails;

    }

    public function categoriesUpdateQueryData(){

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $img='';//$_POST['img'];
        $user_id=1;
        $category_description=$_POST['category_description'];

        $column='name,status,user_id,description';
        $dataQuery="name = '".$category_name."', status = '".$category_status."', description = '".$category_description."'";

        $categoryDetails=['dataQuery'=>$dataQuery];

        return $categoryDetails;

    }

}


    $CategoriesObj = new CategoryController;
    $table=$CategoriesObj->table;

    if(isset($_POST['category_id']) and $_POST['category_id']!=""){

        $id=$_POST['category_id'];
        $CategoryUpdatedetails=$CategoriesObj->categoriesUpdateQueryData();
        $dataQuery=$CategoryUpdatedetails['dataQuery'];
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

        $CategoryUpdateResponse=$CategoriesObj->update($table,$dataQuery,$id);


        if($CategoryUpdateResponse['status']==1){

            header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
        }else{
            header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
        }

        exit;

    }
    $Categorydetails=$CategoriesObj->categoriesQueryData();
    $values=$Categorydetails['values'];
    $column=$Categorydetails['column'];

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

    $CategoryStoreResponse=$CategoriesObj->store($table,$column,$values);

    if($CategoryStoreResponse['status']==1){

        header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
    }else{
        header('Location:../../views/category/category-registration.php?message='.$CategoryStoreResponse['message']);
    }


?>
