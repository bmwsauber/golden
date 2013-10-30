<?php
class Esav_Libidoorder_Block_Adminhtml_Libidoorder_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("libidoorder_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("libidoorder")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("libidoorder")->__("Item Information"),
				"title" => Mage::helper("libidoorder")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("libidoorder/adminhtml_libidoorder_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
