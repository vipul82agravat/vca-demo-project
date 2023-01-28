<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

class CategoryController extends Helpercls {

    /*
    name of table for save Category Details
     */
    public $table='categories';

    /*
     categoriesQueryData Details return the string  for data value and clounm list for save category Details
    */
    public function categoriesQueryData(){

        $this->formValidation();
        session_start();

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $user_id=$_SESSION['user_id'];
        $category_description=$_POST['category_description'];

        $column='name,status,user_id,description';
        $data="'".$category_name."','".$category_status."','".$user_id."','".$category_description."'";

        $categoryDetails=['column'=>$column,
            'values'=>$data];

        return $categoryDetails;

    }
    /*
   categoriesUpdateQueryData Details  return the string  for data value and clounm list for update category Details
  */
    public function categoriesUpdateQueryData(){

        $this->formValidation();

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $user_id=$_SESSION['user_id'];
        $category_description=$_POST['category_description'];

        //echo $fileDestination;exit;
        $column='name,status,user_id,img,img_path,description';
        $dataQuery="name = '".$category_name."', status = '".$category_status."',description = '".$category_description."'";

        $categoryDetails=['dataQuery'=>$dataQuery];

        return $categoryDetails;

    }
    /*
    *formValidation(); is used to check the  require feild is not empty if it empty it return the back with error
    * error is shwoing to user requre feild must be not left blank
    */
    public  function  formValidation(){

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];


        $error_message=[];
        $is_error=0;

        if(empty($category_name)){
            $error_message[$is_error]="Please Enter Category Name";
            $is_error++;
        }
        if(empty($category_status)){
            $error_message[$is_error]="Please Select Category Status";
            $is_error++;
        }

        if( $is_error >=1) {
            $error_string = implode(",", $error_message);
            header('Location:../../views/category/category-add.php?is_error=0&server_error='.$error_string);
            exit;
        }
        return true;

    }
}


    $categoriesObj = new CategoryController;
    $table=$categoriesObj->table;

    if(isset($_POST['category_id']) and $_POST['category_id']!=""){

        $id=$_POST['category_id'];
        $CategoryUpdatedetails=$categoriesObj->categoriesUpdateQueryData();
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
        $categoryUpdateResponse=$categoriesObj->update($table,$dataQuery,$id);

        if($categoryUpdateResponse['status']==1){

            header('Location:../../views/category/category-index.php?is_error=0&message='.$categoryUpdateResponse['message']);
        }else{
            header('Location:../../views/category/category-index.php?is_error=1&message='.$categoryUpdateResponse['message']);
        }

        exit;

    }
    /*
    * check the type in post request this means type of category_date_filter and call this serach the category
     *check the data ne between start and end date
    * return the result is found
    * if recrods is found at that time crate  category details
    */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="category_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/category/category-index.php?start_date='.$start_date.'&end_date='.$end_date);
        exit;
    }
    $categoryDetails=$categoriesObj->categoriesQueryData();
    //print_r($categoryDetails);exit;
    $values=$categoryDetails['values'];
    $column=$categoryDetails['column'];

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

    $categoryStoreResponse=$categoriesObj->store($table,$column,$values);

    if($categoryStoreResponse['status']==1){

        header('Location:../../views/category/category-index.php?is_error=0&message='.$categoryStoreResponse['message']);
    }else{
        header('Location:../../views/category/category-registration.php?is_error=1&message='.$categoryStoreResponse['message']);
    }


?>
