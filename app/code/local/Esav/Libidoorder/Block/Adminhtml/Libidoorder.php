<?php


class Esav_Libidoorder_Block_Adminhtml_Libidoorder extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_libidoorder";
	$this->_blockGroup = "libidoorder";
	$this->_headerText = Mage::helper("libidoorder")->__("Libidoorder Manager");
	$this->_addButtonLabel = Mage::helper("libidoorder")->__("Add New Item");
	parent::__construct();
	
	}

}