<?php
class Esav_Libidoorder_IndexController extends Mage_Core_Controller_Front_Action
{
    /*
    public function IndexAction()
    {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); 
	  
    }
    */

    public function savePostAction()
    {
        // http://libido/index.php/libidoorder/index/savePost
		//http://goldenlibido.soft-loft.com/index.php/libidoorder/index/savePost
       //Array ( [product] => 2 [product_sku] => golden_libido_active [related_product] => [firstname] => Andrey Andr [email] => callmeandrey@gmail.com [mobile_number] => 0686100310 
	   //      [country] => uk [address] => Ukrain Kharkov [qty] => 2 [confirm] => on [price] => 84.66 [total] => 169.32 [product_id] => 2 [currency] => USD ) Esav_Libidoorder_IndexController savePostAction()
	   //$session = $this->_getSession();
        $session = Mage::getSingleton('customer/session');
        if ($this->getRequest()->isPost())
        {
            //echo 'savePostAction()';
            $params=$this->getRequest()->getPost();
            //print_r($params);die('Esav_Libidoorder_IndexController   savePostAction()');
            try
            {
                //if( is_int($params['product_id']) )
                $product_id=$params['product_id'];
                if($product_id)
                { //echo 'product_id='.$product_id;
                    $model = Mage::getModel('catalog/product');
                    $_product = $model->load($product_id);
                }
                $qty=1;
                //if( is_int($params['qty']) )
                //$qty=$params['qty']; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                if($_product)
                {
                    $email= (string)$params['email'];
                    if (!Zend_Validate::is($email, 'EmailAddress')) {  Mage::throwException($this->__('Please enter a valid email address.')); }
					if (!$params['product_sku'] ||  (!strlen($params['product_sku'])>0) ) {  Mage::throwException($this->__("No data 'product_sku'")); }
                    $new_data=array();
                    $price_final=$_product->getFinalPrice();
                    //echo 'qty='.$qty.'price_final='.$price_final;
                    $new_data['sum']=$qty*$price_final;
                    $new_data['qty']=1;  //$qty;  // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $new_data['product_id']=$product_id;

                    $new_data['name']=$params['firstname'];
                    //$new_data['last_name']='';
                    $new_data['email']=$email;
                    $new_data['mobile']=$params['mobile_number'];
                    $new_data['address']=$params['address'];
                    $new_data['zipcode']=$params['zip'];
                    $new_data['country']=$params['country'];
                    $new_data['city']=$params['city'];
					$new_data['product_sku']=$params['product_sku'];

                    $new_data['qty_per_month']=$params['qty_per_month'];
                    $new_data['how_many_months']=$params['how_many_months'];
                    if($params['address_for_delivery']) $new_data['use_this_address_for_delivery']='1';
                    if($params['newsletter']) $new_data['newsletter']='1';
                    $new_data['monthly_shipments']=$params['monthly_shipments'];
                    $new_data['both_products_every_month']=$params['address'];
                    $new_data['how_many_months']=$params['address'];
                    $new_data['location']=$params['address'];
                    $new_data['currency']=$params['currency'];

                    $new_data['price']=$price_final;
						
                    //$new_data['user_id']='';
					//print_r($new_data);die('Esav_Libidoorder_IndexController   savePostAction()');
					//Array ( [sum] => 253.98 [qty] => 3 [product_id] => 2 [name] => Andrey Andr [email] => callmeandrey@gmail.com [mobile] => 0686100310 [address] => Ukrain Kharkov [zipcode] => 31064 [country] => uk 
					//  [city] => [product_sku] => golden_libido_active [qty_per_month] => [how_many_months] => Ukrain Kharkov [monthly_shipments] => [both_products_every_month] => Ukrain Kharkov [location] => Ukrain Kharkov 
					//  [currency] => USD [price] => 84.66 ) Esav_Libidoorder_IndexController savePostAction()

                    $model = Mage::getModel("libidoorder/libidoorder")
                        ->addData($new_data)
                        ->save();
                    $session->addSuccess($this->__('Thank you for your order.') );

                }
            }
            catch (Mage_Core_Exception $e)
            {
                $message = $e->getMessage();
                //die($message);
                $session->addError($message);
            }
            catch (Exception $e)
            {
                //die($e->getMessage());
                $session->addError($e->getMessage());
            }
            try
            {
                if($params['newsletter'])
                {
                    $email= (string)$params['email'];
                    if (!Zend_Validate::is($email, 'EmailAddress')) {  Mage::throwException($this->__('Please enter a valid email address.')); }

                    Mage::getModel('newsletter/subscriber')->setImportMode(true)->subscribe($params['email']);// create new subscriber without send an confirmation email
                    //$session->addSuccess($this->__('Thank you for your subscription.'));
                }
            }
            catch (Mage_Core_Exception $e)  {  $session->addException($e, $this->__('There was a problem with the subscription: %s', $e->getMessage()));  }
            catch (Exception $e) { $session->addException($e, $this->__('There was a problem with the subscription.'));  }

            $this->_redirect('thank-order');
            //exit;
        }
        else
        {
            //echo "not POST";
            $session->addError($this->__('Error ,request is not post') );
            $this->_redirect('*/*/');
        }
        //if ($this->_getSession()->isLoggedIn())  { $this->_redirect('*/*/');  return;  }

    }
}