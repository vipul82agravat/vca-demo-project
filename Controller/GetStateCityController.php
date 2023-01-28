<?php
use Helper\Master\HelperClass as Helpercls;
include_once('../Helper/HelperClass.php');


class GetStateCityController extends Helpercls{

    /*
    name of table for get the city and state information
     */
    public $table_states='states';
    public $table_city='cities';


    /*
     getState  return the string  of find the state base on county_id clounm list for check the if any state  extis or not
    return query string
    */
    public function getState(){

        $countrie_id=$_POST['coutry_id'];
        $stateData=" WHERE country_id='$countrie_id'";
        return $stateData;
    }
    /*
       getCity  return the string  of find the state base on state_id clounm list for check the if any city  extis or not
      return query string
      */
    public function getCity(){

        $state_id=$_POST['state_id'];
        $citydata=" WHERE state_id='$state_id'";
        return $citydata;
    }


}
    $getStateCity = new GetStateCityController;
    $table_states=$getStateCity->table_states;
    $table_city=$getStateCity->table_city;

    if(isset($_POST['coutry_id']) and $_POST['coutry_id']!=""){
        $getStateQuery=$getStateCity->getState();

        /* use ajax call for  state
      * ShowConditionalBaseDetails is used to get the data base Conditional like user_id=1, name = test etc...
      * $table - name of table to get the data form table
      * $data is set the Condition when call this function
      * process data base on Condition and given the response
        return the state information base on country
      */
        $stateResponseData=$getStateCity->ShowConditionalBaseDetails($table_states,$getStateQuery);

        if (mysqli_num_rows($stateResponseData['data']) >= 0) {

            $i=0;

            while ($row = mysqli_fetch_array($stateResponseData['data'])) {

              echo  "<option value=".$row["id"]."> ".$row["name"]."</option>";
            }

        }else{
            echo  "<option>".'----'."</option>";
        }
        exit;
    }
    if(isset($_POST['state_id']) and $_POST['state_id']!=""){
        $getCityQuery=$getStateCity->getCity();

        /* use ajax call for get city
       * ShowConditionalBaseDetails is used to get the data base Conditional like user_id=1, name = test etc...
      * $table - name of table to get the data form table
      * $data is set the Condition when call this function
      * process data base on Condition and given the response
         *  return the city information base on state
      */
        $cityResponseData=$getStateCity->ShowConditionalBaseDetails($table_city,$getCityQuery);

        if (mysqli_num_rows($cityResponseData['data']) >= 0) {

            $i=0;

            while ($row = mysqli_fetch_array($cityResponseData['data'])) {

                echo  "<option value=".$row["id"]."> ".$row["city"]."</option>";
            }

        }else{
            echo  "<option>".'----'."</option>";
        }
        exit;
    }

?>
