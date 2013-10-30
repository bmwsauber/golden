<?php
	
class Esav_Libidoorder_Block_Adminhtml_Libidoorder_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "libidoorder_id";
				$this->_blockGroup = "libidoorder";
				$this->_controller = "adminhtml_libidoorder";
				$this->_updateButton("save", "label", Mage::helper("libidoorder")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("libidoorder")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("libidoorder")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("libidoorder_data") && Mage::registry("libidoorder_data")->getId() ){

				    return Mage::helper("libidoorder")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("libidoorder_data")->getId()));

				} 
				else{

				     return Mage::helper("libidoorder")->__("Add Item");

				}
		}
}