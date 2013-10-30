<?php
require_once("app/Mage.php");
Mage::app();
//Mage::app('default');
$myOrder=Mage::getModel('sales/order');
//$orders=Mage::getModel('sales/mysql4_order_collection');

/* Format our dates */
$fromDate='2013-8-10 0:0:0';
$toDate='2013-8-30 0:0:0';
$fromDate = date('Y-m-d H:i:s', strtotime($fromDate));
$toDate = date('Y-m-d H:i:s', strtotime($toDate));

/* Get the collection */
$orders = Mage::getModel('sales/order')->getCollection()
    //->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
    //->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
;
//echo 'count='.count($orders).'<br/>';
//Optional filters you might want to use - more available operations in method _getConditionSql in Varien_Data_Collection_Db.
//$orders->addFieldToFilter('total_paid',Array('gt'=>0)); //Amount paid larger than 0
//$orders->addFieldToFilter('status',Array('eq'=>"processing"));  //Status is "processing"

$allIds=$orders->getAllIds();
$row=0;
$text='';
foreach($allIds as $thisId)
{
    //$myOrder->load($thisId);
    $myOrder->reset()->load($thisId);
    $myData=$myOrder->getData();
    if($row==0)
    {
        $fieldname = array();
       foreach($myData  as $key => $value)
        {
            $fieldname[]=$key;
            $text.='"'.$key.'"'.',';
        }
        $text.="\r\n";
        //print stripslashes(implode(',',$fieldname)) . "\n";
    }
    $row++;
    $field_data = array();
    foreach($myData  as $key => $value)
    {
        $field_data[]=$value;
        $text.='"'.$value.'"'.',';
    }
    $text.="\r\n";
    //print stripslashes(implode(',',$field_data)) . "\n";
    /*   echo "<pre>";
       print_r($myData);
   echo "</pre>";

   //Some random fields
    echo "'" . $myOrder->getBillingAddress()->getLastname() . "',";
    echo "'" . $myOrder->getTotal_paid() . "',";
    echo "'" . $myOrder->getShippingAddress()->getTelephone() . "',";
    echo "'" . $myOrder->getPayment()->getCc_type() . "',";
    echo "'" . $myOrder->getStatus() . "',";
    echo "'" . $myOrder->getCreatedAt() . "',";

    echo "\r\n";
    */
    $file = 'orders.csv';
    file_put_contents($file, $text);
    echo $text.'<br/>';

    $ftp_file = 'orders_libido.csv';
    $ftp_server='nihonsport.soft-loft.com';// http://nihonsport.soft-loft.com/
    $ftp_user_name='nihonsport@soft-loft.com';
    $ftp_user_pass='QaWsEd123';

    $fp = fopen($file, 'r');
    $conn_id = ftp_connect($ftp_server);
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
    /*
    // start upload
    $ret = ftp_nb_fput($conn_id, $ftp_file , $fp, FTP_BINARY);
    while ($ret == FTP_MOREDATA)
    {
        // производим какие-то действия ...
        echo ".";
        // продолжение закачивания ...
        $ret = ftp_nb_continue($conn_id);
    }
    if ($ret != FTP_FINISHED)
    {
        echo "Error upload to FTP ...";
        exit(1);
    }
    else "Ok!";
    */
    // попытка закачивания файла
    if (ftp_fput($conn_id, $ftp_file, $fp, FTP_ASCII)) {
        echo "File $file was uploaded \n";
    } else {
        echo "Error uploading  $file  \n";
    }

    // закрываем соединение и дескриптор файла
    ftp_close($conn_id);


    fclose($fp);
}