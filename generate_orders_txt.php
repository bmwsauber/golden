<?php 
// http://libido/generate_orders_txt.php
// http://goldenlibido.soft-loft.com/generate_orders_txt.php?from=2013-8-10 00:00:00&to=2013-10-30 00:00:00
function filter_mydate($s) {
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
$myOrder=Mage::getModel('sales/order');

$file = 'CUSORDERFILE.txt';
$ftp_file = 'CUSORDERFILE.txt';
$ftp_server='nihonsport.soft-loft.com';// http://nihonsport.soft-loft.com/
$ftp_user_name='nihonsport@soft-loft.com';
$ftp_user_pass='QaWsEd123';

$ftp_server= Mage::getStoreConfig('orders/soap/adress',Mage::app()->getStore());
$ftp_user_name= Mage::getStoreConfig('orders/soap/user',Mage::app()->getStore());
$ftp_user_pass= Mage::getStoreConfig('orders/soap/psw',Mage::app()->getStore());
//echo $ftp_server.'-'.$ftp_user_name.'-'.$ftp_user_pass; die('   ----- generate_orders_txt.php -- ');

/* Format our dates */
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
//$today = date("Y-m-d H:i:s");
//echo $today;
// $from = date("Y-m-d", strtotime('-120 day'));
//$to = date("Y-m-d", strtotime('-1 day'));
//$toDate=$today ;

/* Get the collection */
$orders = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate,'date' => true,))
    //->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
;
//echo 'count='.count($orders).'<br/>';

$allIds=$orders->getAllIds();
$row=0;
$text='';
$text.="YOURNO;YOURREF;CUR;ACCOUNT;TEXT;PART;QTY;PRICE;NOTE;CUSPART;REQ;SHIPBY;SNAME;SADDR1;SADDR2;SCITY;SPOCODE;SCOUNTRY;PAYTERM;FREIGHT;SATTN";
$text.="\r\n";
foreach($allIds as $thisId)
{
    //if($row==0)  { continue; }
    $row++;
    //$myOrder->load($thisId);
    $myOrder->reset()->load($thisId);
    $myData=$myOrder->getData();
    $ShippingAddressData=$myOrder->getShippingAddress()->getData();
    //$myData['billing_address_id'];

    //print stripslashes(implode(',',$field_data)) . "\n";
    // echo "<pre>"; print_r($myData); echo "</pre>";
    // echo "<pre>"; print_r($ShippingAddressData); echo "</pre>";

    $text.=$myOrder->getId().";";//YOURNO  Third party order number. Will be displayed on the packing note and shipping lables.
    $text.=$myData['product_sku'].";";//YOURREF  Order reference. For example the recievers purchase-number or other references.
    $text.=$myData['order_currency_code'].";";//CUR
    $text.="not defined;";//ACCOUNT This is a fixed account number of our customer. Example: 12345
    $text.=";";//TEXT (not used)
    $text.="not defined;";//PART Product partnumber.
    $text.=(int)$myData['total_qty_ordered'].";";//QTY
    //$text.=$myOrder->getTotal_paid().";";//PRICE
    $text.=$myData['subtotal_incl_tax'].";";//PRICE
    $text.=";";//NOTE Note/Comment on the current orderline.
    $text.=";";//CUSPART  (not used)
    $text.=date('Y.m.d', strtotime($myData['created_at']) ).";";//REQ Requested date. Format: YYYY.MM.DD
    if($myData['shipping_method'] ) $text.=$myData['shipping_method'].";";//SHIPBY  Shipping method. Default is used if not defined. Example: SERVICEPAKKE
    else $text.="not defined;";//SHIPBY
    $text.=$myData['customer_firstname'].$myData['customer_middlename'].$myData['customer_lastname'].";";//SNAME
    $text.=$ShippingAddressData['street'].";";//SADDR1
    $text.=";";//SADDR2  Second address line of shipping destination
    if($ShippingAddressData['city'] ) $text.=$ShippingAddressData['city'].";";//SCITY City of shipping destination
    else $text.="not defined;";//SCITY
    if($ShippingAddressData['postcode']) $text.=$ShippingAddressData['postcode'].";";//SPOCODE Postal code of shipping destination.
    else $text.="not defined;";	
    if($ShippingAddressData['country_id']) $text.=$ShippingAddressData['country_id'].";";//SCOUNTRY  Countrycode of shipping destination. Example: NO or GB
    else $text.="not defined;";
	if($ShippingAddressData['payterm']) $text.=$myData['payterm'];//PAYTERM
    else $text.="not defined;";
    if($ShippingAddressData['freight']) $text.=$myData['freight'];//FREIGHT  Cost of freight. If multiple lines on the same order, this field must only have a value in the first row
    else $text.="not defined;";
	if($ShippingAddressData['sattn']) $text.=$myData['sattn'];//SATTN
    else $text.="not defined;";
	$text.="\r\n";
}

    $text = iconv("UTF-8", "Windows-1252", $text);   

    file_put_contents($file, $text);

    $fp = fopen($file, 'r');
    $conn_id = ftp_connect($ftp_server);
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    // попытка закачивания файла
    if (ftp_fput($conn_id, $ftp_file, $fp, FTP_ASCII)) {
        echo $text."<br/><br/>File  was uploaded to ".$ftp_server."/".$file." \n";
    } else {
        echo "Error uploading  $file  \n";
    }

    // закрываем соединение и дескриптор файла
    ftp_close($conn_id);

    fclose($fp);


