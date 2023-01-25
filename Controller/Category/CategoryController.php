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

        session_start();
        $fileName = basename($_FILES["category_img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imgContent ='';

        $uploads_dir =$_SERVER['DOCUMENT_ROOT']."/public/image/category/";
        $fileDestination = $uploads_dir.$fileName;

        //echo $fileDestination;exit;
        if(in_array($fileType, $allowTypes)){
            $tmp_name = $_FILES['category_img']['tmp_name'];
            $imgContent = '';//addslashes(file_get_contents($tmp_name));

            move_uploaded_file($tmp_name,$fileDestination);

        }

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $img='';//$_POST['img'];
        $user_id=$_SESSION['user_id'];
        $category_description=$_POST['category_description'];

        $column='name,status,user_id,img,img_path,description';
        $data="'".$category_name."','".$category_status."','".$user_id."','".$imgContent."','".$fileName."','".$category_description."'";

        $categoryDetails=['column'=>$column,
            'values'=>$data];

        return $categoryDetails;

    }
    /*
   categoriesUpdateQueryData Details  return the string  for data value and clounm list for update category Details
  */
    public function categoriesUpdateQueryData(){

        $category_name=$_POST['category_name'];
        $category_status=$_POST['category_status'];
        $img='';//$_POST['img'];
        $user_id=$_SESSION['user_id'];
        $category_description=$_POST['category_description'];

        $fileName = basename($_FILES["category_img"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imgContent ='';
        $uploads_dir =$_SERVER['DOCUMENT_ROOT']."/public/category/";
        $fileDestination = $uploads_dir.$fileName;

        if(in_array($fileType, $allowTypes)){
            $tmp_name = $_FILES['category_img']['tmp_name'];
            $imgContent = addslashes(file_get_contents($tmp_name));
            move_uploaded_file($tmp_name,$fileDestination);

        }
//        echo $tmp_name;
        //echo $fileDestination;exit;
        $column='name,status,user_id,img,img_path,description';
        $dataQuery="name = '".$category_name."', status = '".$category_status."', img = '".$imgContent."', img_path = '".$fileName."', description = '".$category_description."'";

        $categoryDetails=['dataQuery'=>$dataQuery];

        return $categoryDetails;

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

        $CategoryUpdateResponse=$categoriesObj->update($table,$dataQuery,$id);


        if($CategoryUpdateResponse['status']==1){

            header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
        }else{
            header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
        }

        exit;

    }
    /*
    * chgeck the type in post request this means type of serach and call this form ajax request for serach the prodcut
    * $_POST['serach_text']; get the string fors serach the check the  getProductDetails with like condtion
    * return the result is found
    * if recrods is found at that time crate html div in loop and greate the final html code
    * and return this code on ajax reponse and set in view page
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

    $CategoryStoreResponse=$categoriesObj->store($table,$column,$values);

    if($CategoryStoreResponse['status']==1){

        header('Location:../../views/category/category-index.php?message='.$CategoryStoreResponse['message']);
    }else{
        header('Location:../../views/category/category-registration.php?message='.$CategoryStoreResponse['message']);
    }


?>
