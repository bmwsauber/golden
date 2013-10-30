<?php
class Esav_Libidoorder_LibidoorderController extends Mage_Core_Controller_Front_Action{
		public function IndexAction() {
				  
				  $this->loadLayout();   
				  $this->getLayout()->getBlock("head")->setTitle($this->__("Libidoorder"));
						$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
				  $breadcrumbs->addCrumb("home", array(
							"label" => $this->__("Home Page"),
							"title" => $this->__("Home Page"),
							"link"  => Mage::getBaseUrl()
					   ));

				  $breadcrumbs->addCrumb("titlename", array(
							"label" => $this->__("Libidoorder"),
							"title" => $this->__("Libidoorder")
					   ));

				  $this->renderLayout(); 
				  
		}
}