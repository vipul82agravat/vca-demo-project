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

$id=$_GET['id'];
$selectData="products.id as product_id,products.title as title,products.location as location,products.postcode as postcode,products.company_name as company_name,products.address as address,products.status as status,products.description as description,products.img as image,products.img_path as img_path,products.create_at as create_date,products.updated_at as update_date  ,categories.name as catgory_name,states.name as states_name,cities.city as city_name";
$data=' WHERE products.id ='.$id;
/*
       * getProductDetails function used to get the product details with join data base on category,state,city
       * $data pass and where condidtion if require
       * $selectData select clounm list in response it pass alias name
       * it return the resonsedata base on all three table
 */

$productData=$masterObject->getProductDetails($data,$selectData);
$row="";
if (mysqli_num_rows($productData['data']) > 0) {
    $row = mysqli_fetch_assoc($productData['data']);
}

/*
 * Get the tablke for data of product commet
 * it join form two table data
 * pass table1 and table 2
 * pass the same key of both table
 * get the return of data form join with both table
 */
$table1="products_comments";
$table2="products";
$data=' WHERE products_comments.product_id ='.$id;
$selectData="products_comments.id as d,products_comments.comments as comments,products.title as products_name,products_comments.product_id as product_id";
$productCommentData=$masterObject->leftJoinData($table1,$table2,'product_id','id',$data,$selectData);
if (mysqli_num_rows($productCommentData['data']) > 0) {

    $i=0;
    $productCommentrow=array();
    while ($commentrow = mysqli_fetch_array($productCommentData['data'])) {
        $productCommentrow[$i]['number']=$i+1;
        $productCommentrow[$i]['id']=$commentrow['id'];
        $productCommentrow[$i]['comments']=$commentrow['comments'];
        $productCommentrow[$i]['product_name']=$commentrow['product_name'];
        $i++;
    }

}


$parameters = [
    'product'=>$row,
    'is_error'=>$_GET["is_error"],
    'message'=>str_replace('Records','Comment',$_GET["message"]),
    'user_role'=>$loginUserRole,
    'product_id'=>$id,
    'adsleftDataresult'=>$adsleftDataresult,
    'adsrightDataresult'=>$adsrightDataresult,
    'productCommentData'=>$productCommentrow
];
 // Render our view
 echo $twig->render('/users/user-products-view.html.twig',$parameters);
