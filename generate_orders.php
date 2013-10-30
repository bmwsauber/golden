<?php 
// http://libido/generate_orders_txt.php
// http://goldenlibido.soft-loft.com/generate_orders.php?from=2013-8-10 00:00:00&to=2013-10-30 00:00:00
function filter_mydate($s) {
	if(!$s)return false;
    if (preg_match('@^(\d\d\d\d)-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$@', $s, $m) == false) {
		die($s.'  error date format !<br/>');
        return false;
    }
    if (checkdate($m[2], $m[3], $m[1]) == false || $m[4] >= 24 || $m[5] >= 60 || $m[6] >= 60) {
        return false;
    }
    return $s;
}

require_once("app/Mage.php");
Mage::app();
//Mage::app('default');
$myOrder=Mage::getModel('libidoorder/libidoorder');

$file = 'CUSORDERFILE.txt';
$ftp_file = 'CUSORDERFILE.txt';
$ftp_server='nihonsport.soft-loft.com';// http://nihonsport.soft-loft.com/
$ftp_user_name='nihonsport@soft-loft.com';
$ftp_user_pass='QaWsEd123';

$ftp_server= Mage::getStoreConfig('orders/soap/adress',Mage::app()->getStore());
$ftp_user_name= Mage::getStoreConfig('orders/soap/user',Mage::app()->getStore());
$ftp_user_pass= Mage::getStoreConfig('orders/soap/psw',Mage::app()->getStore());
//echo $ftp_server.'-'.$ftp_user_name.'-'.$ftp_user_pass; die('   ----- generate_orders_txt.php -- ');

$params=Array();
$params = Mage::app()->getRequest()->getParams();

//var_dump( validateDate($params['from']) );var_dump(validateDate($params['to']) );exit;
$today = date("Y-m-d");
$yestoday=date("Y-m-d", strtotime('-1 day'));
if(filter_mydate($params['from'])) $fromDate=$params['from']; else $fromDate=$yestoday;
if(filter_mydate($params['to']) ) $toDate=$params['to']; else $toDate=$today;
//echo $fromDate.'--'.$toDate; exit;
$fromDate = date('Y-m-d H:i:s', strtotime($fromDate));
$toDate = date('Y-m-d H:i:s', strtotime($toDate));
echo 'from:'.$fromDate.' to:'.$toDate.'<br/>';

$orders = Mage::getModel('libidoorder/libidoorder')->getCollection()
	->addFieldToFilter( 'created_at', array('from'=>$fromDate, 'to'=>$toDate,'date' => true,) )
    //->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate,'date' => true,))
    //->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
;
//echo 'count='.count($orders).'<br/>';

$allIds=$orders->getAllIds();
$row=0;
$text='';
$text.="order_id;created_at;product_sku;name;email;mobile;address;zipcode;country;qty;price;sum;currency;";
$text.="\r\n";
foreach($allIds as $thisId)
{
    //if($row==0)  { continue; }
    $row++;
	$myOrder = Mage::getModel('libidoorder/libidoorder')->load($thisId);
    $myData=$myOrder->getData();
	//print_r ($myData);die('--generate_orders.php --');

    $text.=$myOrder->getId().";";
    $text.=$myData['created_at'].";";
    $text.=$myData['product_sku'].";";
    $text.=$myData['name'].";";
    //$text.=$myData['last_name'].";";
	$text.=$myData['email'].";";
	$text.=$myData['mobile'].";";
	$text.=$myData['address'].";";
	$text.=$myData['zipcode'].";";
	//$text.=$myData['location'].";";
	$text.=$myData['country'].";";
	//$text.=$myData['city'].";";
	$text.=$myData['qty'].";";
	$text.=$myData['price'].";";
	$text.=$myData['sum'].";";
    $text.=$myData['currency'].";";
   
	$text.="\r\n";
}

    $text = iconv("UTF-8", "Windows-1252", $text);   

    file_put_contents($file, $text);

    $fp = fopen($file, 'r');
    $conn_id = ftp_connect($ftp_server);
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    // try upload file
    if (ftp_fput($conn_id, $ftp_file, $fp, FTP_ASCII)) {
        echo $text."<br/><br/>File  was uploaded to ".$ftp_server."/".$file." \n";
    } else {
        echo "Error uploading  $file  \n";
    }

    // close connection and descriptor
    ftp_close($conn_id);

    fclose($fp);


