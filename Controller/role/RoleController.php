<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../../Helper/HelperClass.php');

class RoleController extends Helpercls {

    /*
    name of table for save role Details
     */
    public $table='role';

    /*
     roleQueryData Details  return the string  for data value and clounm list for save role Details
    */
    public function roleQueryData(){

        $role_name=$_POST['role_name'];
        $role_status=$_POST['role_status'];
        $status_code=$_POST['status_code'];
        $role_description=$_POST['role_description'];

        $column='name,status,status_code,description';
        $data="'".$role_name."','".$role_status."','".$status_code."','".$role_description."'";

        $roleDetails=['column'=>$column,
            'values'=>$data];

        return $roleDetails;

    }
     /*
     roleUpdateQueryData Details  return the string  for data value and clounm list for update role Details
    */
    public function roleUpdateQueryData(){

        $role_name=$_POST['role_name'];
        $role_status=$_POST['role_status'];
        $status_code=$_POST['status_code'];
        $role_description=$_POST['role_description'];

        $dataQuery="name = '".$role_name."', status_code = '".$status_code."',status = '".$role_status."',description = '".$role_description."'";

        $roleDetails=['dataQuery'=>$dataQuery];

        return $roleDetails;

    }

}

    $roleObj = new RoleController;
    $table=$roleObj->table;

    if(isset($_POST['role_id']) and $_POST['role_id']!=""){

        $id=$_POST['role_id'];
        $roleUpdatedetails=$roleObj->roleUpdateQueryData();
        $dataQuery=$roleUpdatedetails['dataQuery'];

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
        $roleUpdateResponse=$roleObj->update($table,$dataQuery,$id);

        if($roleUpdateResponse['status']==1){

            header('Location:../../views/role/role-index.php?message='.$roleUpdateResponse['message']);
        }else{
            header('Location:../../views/role/role-index.php?message='.$roleUpdateResponse['message']);
        }

        exit;

    }
    if(isset($_POST['type']) and $_POST['type']!="" and $_POST['type']=="role_date_filter"){
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        header('Location:../../views/role/role-index.php?start_date='.$start_date.'&end_date='.$end_date);
    }
    //print_r($_POST);EXIT;
    $roledetails=$roleObj->roleQueryData();
    $column=$roledetails['column'];
    $values=$roledetails['values'];
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


            $roleResponse=$roleObj->store($table,$column,$values);

            if($roleResponse['status']==1){

                header('Location:../../views/role/role-index.php?message='.$roleResponse['message']);
            }else{
                header('Location:../../views/role/role-index.php?message='.$roleResponse['message']);
            }




?>
