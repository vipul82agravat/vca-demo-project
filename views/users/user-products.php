<?php
use Helper\Master\HelperClass as Helpercls;
use Helper\Auth\AuthCheck as Auth;
include_once('../../Helper/HelperClass.php');

$bootstrap_file=$_SERVER['DOCUMENT_ROOT'].'/views/bootstrap.php';;
require_once $bootstrap_file;

$masterObject = new Helpercls();


    /*Get the left position Ads data base on user condition
    $id user login id it return all  user added ads
    $table - name of table for get the ads data
    $data the condition of get data base in user id
    */
    $adsleftDataresult=[];
    $date=date('Y-m-d');
    $table1="products_ads";
    $table2="products";
    $tab1key="product_id";
    $tab2key="id";
    $data="where products_ads.ads_position='left' and  start_date <='".$date."' and end_date >='".$date."' and products_ads.status='1' ORDER BY products_ads.sort_number ASC limit 3";

    $selectData="products.id as product_id,products.title as product_name,products.img_path as img_path,products_ads.ads_position as ads_position,products_ads.sort_number as sort_number,products_ads.start_date as start_date,products_ads.end_date as end_date,products_ads.status as status,products_ads.description as description,products_ads.id as ids";
    $adsData=$masterObject->leftJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData);
    if (mysqli_num_rows($adsData['data']) > 0) {

        $i=0;
        $adsleftDataresult=array();
        while ($row = mysqli_fetch_array($adsData['data'])) {

            $adsleftDataresult[$i]['id']=$row['ids'];
            $adsleftDataresult[$i]['product_id']=$row['product_id'];
            $adsleftDataresult[$i]['product_name']=$row['product_name'];
            $adsleftDataresult[$i]['product_img']=$row['img_path'];
            $adsleftDataresult[$i]['ads_position']=$row['ads_position'];
            $adsleftDataresult[$i]['sort_number']=$row['sort_number'];
            $adsleftDataresult[$i]['start_date']=$row['start_date'];
            $adsleftDataresult[$i]['end_date']=$row['end_date'];
            $adsleftDataresult[$i]['status']=$row['status']==1 ? "Active" :"InActive"   ;
            $adsleftDataresult[$i]['description']=$row['description'];
            $i++;

        }

    }

    /*Get the right position Ads data base on user condition
    $id user login id it return all  user added ads
    $table - name of table for get the ads data
    $data the condition of get data base in user id
    */

    $table1="products_ads";
    $table2="products";
    $date=date('Y-m-d');
    $tab1key="product_id";
    $tab2key="id";
    $data="where products_ads.ads_position='right' and  start_date <='".$date."' and end_date >='".$date."' and products_ads.status='1' ORDER BY products_ads.sort_number ASC limit 3";
    $selectData="products.id as product_id,products.title as product_name,products.img_path as img_path,products_ads.ads_position as ads_position,products_ads.sort_number as sort_number,products_ads.start_date as start_date,products_ads.end_date as end_date,products_ads.status as status,products_ads.description as description,products_ads.id as ids";
    $adsData=$masterObject->leftJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData);
    if (mysqli_num_rows($adsData['data']) > 0) {

        $i=0;
        $adsrightDataresult=array();
        while ($row = mysqli_fetch_array($adsData['data'])) {

            $adsrightDataresult[$i]['id']=$row['ids'];
            $adsrightDataresult[$i]['product_id']=$row['product_id'];
            $adsrightDataresult[$i]['product_name']=$row['product_name'];
            $adsrightDataresult[$i]['product_img']=$row['img_path'];
            $adsrightDataresult[$i]['ads_position']=$row['ads_position'];
            $adsrightDataresult[$i]['sort_number']=$row['sort_number'];
            $adsrightDataresult[$i]['start_date']=$row['start_date'];
            $adsrightDataresult[$i]['end_date']=$row['end_date'];
            $adsrightDataresult[$i]['status']=$row['status']==1 ? "Active" :"InActive"   ;
            $adsrightDataresult[$i]['description']=$row['description'];
            $i++;

        }

    }
    /*Get the top position Ads data base on user condition
    $id user login id it return all  user added ads
    $table - name of table for get the ads data
    $data the condition of get data base in user id
    */
    $adstopDataresult=[];
    $table1="products_ads";
    $table2="products";
    $date=date('Y-m-d');
    $tab1key="product_id";
    $tab2key="id";
    $data="where products_ads.ads_position='top' and  start_date <='".$date."' and end_date >='".$date."' and products_ads.status='1' ORDER BY products_ads.sort_number ASC limit 4";
    $selectData="products.id as product_id,products.title as product_name,products.img_path as img_path,products_ads.ads_position as ads_position,products_ads.sort_number as sort_number,products_ads.start_date as start_date,products_ads.end_date as end_date,products_ads.status as status,products_ads.description as description,products_ads.id as ids";
    $adsData=$masterObject->leftJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData);
    if (mysqli_num_rows($adsData['data']) > 0) {

        $i=0;
        $adstopDataresult=array();
        while ($row = mysqli_fetch_array($adsData['data'])) {

            $adstopDataresult[$i]['id']=$row['ids'];
            $adstopDataresult[$i]['product_id']=$row['product_id'];
            $adstopDataresult[$i]['product_name']=$row['product_name'];
            $adstopDataresult[$i]['product_img']=$row['img_path'];
            $adstopDataresult[$i]['ads_position']=$row['ads_position'];
            $adstopDataresult[$i]['sort_number']=$row['sort_number'];
            $adstopDataresult[$i]['start_date']=$row['start_date'];
            $adstopDataresult[$i]['end_date']=$row['end_date'];
            $adstopDataresult[$i]['status']=$row['status']==1 ? "Active" :"InActive"   ;
            $adstopDataresult[$i]['description']=$row['description'];
            $i++;

        }

    }
    /*Get the bottom position Ads data base on user condition
    $id user login id it return all  user added ads
    $table - name of table for get the ads data
    $data the condition of get data base in user id
    */

    $table1="products_ads";
    $table2="products";
    $tab1key="product_id";
    $tab2key="id";
    $data="where products_ads.ads_position='bottom'  ORDER BY products_ads.sort_number ASC limit 3";
    $selectData="products.id as product_id,products.title as product_name,products.img_path as img_path,products_ads.ads_position as ads_position,products_ads.sort_number as sort_number,products_ads.start_date as start_date,products_ads.end_date as end_date,products_ads.status as status,products_ads.description as description,products_ads.id as ids";
    $adsData=$masterObject->leftJoinData($table1,$table2,$tab1key,$tab2key,$data,$selectData);
    if (mysqli_num_rows($adsData['data']) > 0) {

        $i=0;
        $adsbottomDataresult=array();
        while ($row = mysqli_fetch_array($adsData['data'])) {

            $adsbottomDataresult[$i]['id']=$row['ids'];
            $adsbottomDataresult[$i]['product_id']=$row['product_id'];
            $adsbottomDataresult[$i]['product_name']=$row['product_name'];
            $adsbottomDataresult[$i]['product_img']=$row['img_path'];
            $adsbottomDataresult[$i]['ads_position']=$row['ads_position'];
            $adsbottomDataresult[$i]['sort_number']=$row['sort_number'];
            $adsbottomDataresult[$i]['start_date']=$row['start_date'];
            $adsbottomDataresult[$i]['end_date']=$row['end_date'];
            $adsbottomDataresult[$i]['status']=$row['status']==1 ? "Active" :"InActive"   ;
            $adsbottomDataresult[$i]['description']=$row['description'];
            $i++;

        }

    }

    /*Get the category data base on user condtion
    $id user login id it return all  user added category
    $table - name of table for get the category data
    $data the condition of get data base in user id
    */
    $table='categories';

    $data=" WHERE status='1'";

    $categoriesData=$masterObject->ShowConditionalBaseDetails($table,$data);

    $categoriesDataresult=array();
    if (mysqli_num_rows($categoriesData['data']) >= 0) {

        $i = 0;

        while ($row = mysqli_fetch_array($categoriesData['data'])) {

            $categoriesDataresult[$i]['id'] = $row['id'];
            $categoriesDataresult[$i]['name'] = $row['name'];
            $categoriesDataresult[$i]['user_id'] = $row['user_id'];
            $categoriesDataresult[$i]['status'] = $row['status'];
            $categoriesDataresult[$i]['description'] = $row['description'];
            $i++;

        }
    }

$selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
$data=" where products.status='1' ORDER BY products.create_at DESC;";
        /*
        * getProductDetails function used to get the product details with join data base on category,state,city
        * $data pass and where condidtion if require
        * $selectData select clounm list in response it pass alias name
        * it return the resonsedata base on all three table
        */
$productData=$masterObject->getProductDetails($data,$selectData);

$result=0;
if (mysqli_num_rows($productData['data']) > 0) {

    $i=0;
    $result=array();
    while ($row = mysqli_fetch_array($productData['data'])) {

        $result[$i]['title']=$row['title'];
        $result[$i]['id']=$row['product_id'];
        $result[$i]['category_id']=$row['category_id'];
        $result[$i]['catgory_name']=$row['catgory_name'];
        $result[$i]['location']=$row['location'];
        $result[$i]['countries']=$row['countries'];
        $result[$i]['state']=$row['states_name'];
        $result[$i]['city']=$row['city_name'];
        $result[$i]['postcode']=$row['postcode'];
        $result[$i]['company_name']=$row['company_name'];
        $result[$i]['address']=$row['address'];
        $result[$i]['status']=$row['status']==1 ? "Active" : "InActive";
        $result[$i]['description']=$row['description'];
        $result[$i]['create_date']=$row['create_date'];
        $result[$i]['update_date']=$row['update_date'];
        $result[$i]['img_path']=$row['img_path'];
        $result[$i]['image']=$row['image'];
        $i++;

    }

}

$parameters = [
    'is_error' => $_GET['is_error'],
    'status' =>$login_status,
    'message'=>$_GET['message'],
    'row'=>$result,
    'user_role'=>$loginUserRole,
    'login_status' =>Auth::AuthUserId() ? 1 : 0,
    'categories'=>$categoriesDataresult,
    'adsDataresult'=>$adsleftDataresult,
    'adstopDataresult'=>$adstopDataresult

];
 // Render our view
 echo $twig->render('/users/user-products.html.twig',$parameters);
