<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

class  AdsController extends Helpercls {

    /*
    name of table for save role Details
     */
    public $table='products_ads';

    /*
     roleQueryData Details  return the string  for data value and clounm list for save role Details
    */
    public function adsQueryData(){

        $this->formValidation();

        $product_id=$_POST['product_id'];
        $ads_position=$_POST['ads_position'];
        $ads_sort_number=$_POST['ads_sort_number'];
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];
        $ads_status=$_POST['ads_status'];
        $ads_description=$_POST['ads_description'];

        $column='product_id,ads_position,sort_number,start_date,end_date,status,description';
        $data="'".$product_id."','".$ads_position."','".$ads_sort_number."','".$start_date."','".$end_date."','".$ads_status."','".$ads_description."'";

        $adsDetails=['column'=>$column,
            'values'=>$data];

        return $adsDetails;

    }
     /*
     roleUpdateQueryData Details  return the string  for data value and clounm list for update role Details
    */
    public function adsUpdateQueryData(){

       //$this->formValidation();

        $product_id=$_POST['product_id'];
        $ads_position=$_POST['ads_position'];
        $ads_sort_number=$_POST['ads_sort_number'];
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];
        $ads_status=$_POST['ads_status'];
        $ads_description=$_POST['ads_description'];

        $dataQuery="product_id = '".$product_id."', ads_position = '".$ads_position."',sort_number = '".$ads_sort_number."',start_date = '".$start_date."',end_date = '".$end_date."',status = '".$ads_status."',description = '".$ads_description."'";

        $adsDetails=['dataQuery'=>$dataQuery];

        return $adsDetails;

    }
     /*
    *formValidation(); is used to check the  require feild is not empty if it empty it return the back with error
    * error is shwoing to user requre feild must be not left blank
    */
    public  function  formValidation(){

        $product_id=$_POST['product_id'];
        $ads_position=$_POST['ads_position'];
        $ads_sort_number=$_POST['ads_sort_number'];
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];
        $ads_status=$_POST['ads_status'];

        $error_message=[];
        $is_error=0;

        if(empty($product_id)){
            $error_message[$is_error]="Please Select Product";
            $is_error++;
        }
        if(empty($ads_position)){
            $error_message[$is_error]="Please Select Ads position ";
            $is_error++;
        }
        if(empty($ads_sort_number)){
            $error_message[$is_error]="Please Select Sort Numbers";
            $is_error++;
        }
        if(empty($start_date)){
            $error_message[$is_error]="Please Select Start Date";
            $is_error++;
        }
        if(empty($end_date)){
            $error_message[$is_error]="Please Select End Date";
            $is_error++;
        }




        if( $is_error >=1) {
            $error_string = implode(",", $error_message);
            header('Location:../../views/ads/ads-add.php?is_error=0&server_error='.$error_string);
            exit;
        }
        return true;

    }
}

    $adsObj = new AdsController;
    $table=$adsObj->table;
    //print_r($_POST);exit;
    /*
     * found th role it means update the role
     * $get the if of role  in system
     * update new records in base no id
     * now data base table is update with new records
     * check if role is set or not
     */
    if(isset($_POST['ads_id']) and $_POST['ads_id']!=""){

        $id=$_POST['ads_id'];
        $adsUpdatedetails=$adsObj->adsUpdateQueryData();
        $dataQuery=$adsUpdatedetails['dataQuery'];
//        echo $table;
//        echo $id;
//        echo $dataQuery; exit;
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
        $adsUpdateResponse=$adsObj->update($table,$dataQuery,$id);
        if($adsUpdateResponse['status']==1){

            header('Location:../../views/ads/ads-index.php?is_error=0&message='.$adsUpdateResponse['message']);
        }else{
            header('Location:../../views/ads/ads-index.php?is_error=1&message='.$adsUpdateResponse['message']);
        }

        exit;

    }
    /*
    * check the type in post request this means type of role_date_filter and call this serach the role
    *check the data ne between start and end date
    * return the result is found
    * if recrods is found at that time crate  role details
    */
    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="ads_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/ads/ads-index.php?start_date='.$start_date.'&end_date='.$end_date);
        exit;
    }

    $adsdetails=$adsObj->adsQueryData();
    $column=$adsdetails['column'];
    $values=$adsdetails['values'];
    //print_r($adsdetails);exit;
    /*
    * call the helper class Store method for save the records in table
    * $table - name of the table which store the records
    * $data - data values get form submit in role form
    * $clounm -is set the clounm name of table which insert the records base on clounm
    *
    * response
    *  it will return the response when given parameters
    *  status 1 it means Records Save Successfully'
    *  status 0 it means  Records Not Save Successfully'
    */

            $adsResponse=$adsObj->store($table,$column,$values);
            if($adsResponse['status']==1){

                header('Location:../../views/ads/ads-index.php?is_error=0&message='.$adsResponse['message']);
            }else{
                header('Location:../../views/ads/ads-index.php?is_error=1&message='.$adsResponse['message']);
            }




?>
