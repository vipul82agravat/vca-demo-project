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
    /*
     * check if product_id is set it at that time update record using productsUpdateQueryData
     */
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
    /*
     * chgeck the type in post request this means type of serach and call this form ajax request for serach the prodcut
     * $_POST['serach_text']; get the string fors serach the check the  getProductDetails with like condtion
     * return the result is found
     * if recrods is found at that time crate html div in loop and greate the final html code
     * and return this code on ajax reponse and set in view page
     */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="serach"){

        $serach_text=$_POST['search_text'];
        $selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
        $data=" WHERE products.title LIKE '%$serach_text%'";

        $ProductsUpdateResponse=$ProductsObj->getProductDetails($data,$selectData);

        $html="Result Not Found...";
        if (mysqli_num_rows($ProductsUpdateResponse['data']) > 0) {

            $html='<div class="row product_list">';
            while ($row = mysqli_fetch_array($ProductsUpdateResponse['data'])) {

                    $title=$row['title'];
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
                <div class="col-sm-7"><img class="img-thumbnail" src="http://www.jquery-az.com/html/images/banana.jpg" alt="user avatar"></div>
                <div class="col-sm-5"><h3>'.$title.'</h3>
                    <p class="w3-opacity">Company Name:: '.$catgory_name.'</p>
                    <p>Description::'.$description.'</p>
                    <p>Address::'.$address.'-'.$state.'-'.$city.'-'.$postcode.'</p>
                    <a href="user-products-view.php?id='.$id.'" id="create" class="btn btn-primary" target="_blank">ViewDetails</a></div>
                <hr>
                ';
            }
            $html.="</div>";
        }

        echo $html;
        exit;
    }
    /*
    * chgeck the type in post request this means type of serach and call this form ajax request for serach the prodcut
    * $_POST['serach_text']; get the string fors serach the check the  getProductDetails with like condtion
    * return the result is found
    * if recrods is found at that time crate html div in loop and greate the final html code
    * and return this code on ajax reponse and set in view page
    */

    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="product_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/products/product-index.php?start_date='.$start_date.'&end_date='.$end_date);
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
