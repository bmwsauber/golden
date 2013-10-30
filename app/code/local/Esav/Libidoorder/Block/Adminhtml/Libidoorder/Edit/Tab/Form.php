<?php
class Esav_Libidoorder_Block_Adminhtml_Libidoorder_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("libidoorder_form", array("legend"=>Mage::helper("libidoorder")->__("Item information")));

				
						$fieldset->addField("libidoorder_id", "text", array(
						"label" => Mage::helper("libidoorder")->__("ID"),
						"name" => "libidoorder_id",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('created_at', 'date', array(
						'label'        => Mage::helper('libidoorder')->__('Created at'),
						'name'         => 'created_at',
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("libidoorder")->__("Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
						/*
						$fieldset->addField("last_name", "text", array(
						"label" => Mage::helper("libidoorder")->__("Last name"),
						"name" => "last_name",
						));
						*/					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("libidoorder")->__("E-mail"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("libidoorder")->__("Mobile number"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "mobile",
						));
					
						$fieldset->addField("address", "text", array(
						"label" => Mage::helper("libidoorder")->__("Address"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "address",
						));
					
						$fieldset->addField("zipcode", "text", array(
						"label" => Mage::helper("libidoorder")->__("Zipcode / City"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "zipcode",
						));
									
						 $fieldset->addField('country', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('Country'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray8(),
						'name' => 'country',					
						"class" => "required-entry",
						"required" => true,
						));
						
						$fieldset->addField("qty", "text", array(
						"label" => Mage::helper("libidoorder")->__("Qty"),
						"name" => "qty",
						));
						$fieldset->addField("sum", "text", array(
						"label" => Mage::helper("libidoorder")->__("Sum"),
						"name" => "sum",
						));
									
						 $fieldset->addField('use_this_address_for_delivery', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('Use this address for delivery'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray11(),
						'name' => 'use_this_address_for_delivery',
						));				
						 $fieldset->addField('newsletter', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('Receive newsletter'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray12(),
						'name' => 'newsletter',
						));	
						/*						
						 $fieldset->addField('monthly_shipments', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('Monthly shipments'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray13(),
						'name' => 'monthly_shipments',
						));				
						 $fieldset->addField('both_products_every_month', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('User pays and gets both products every month.'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray14(),
						'name' => 'both_products_every_month',
						));
						*/
						/*
						$fieldset->addField("qty_per_month", "text", array(
						"label" => Mage::helper("libidoorder")->__("Qty per month"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "qty_per_month",
						));
						*/
						/*
						$fieldset->addField("how_many_months", "text", array(
						"label" => Mage::helper("libidoorder")->__("How many months"),
						"name" => "how_many_months",
						));
						*/
						$fieldset->addField("location", "text", array(
						"label" => Mage::helper("libidoorder")->__("Location"),
						"name" => "location",
						));
						/*			
						 $fieldset->addField('currency', 'select', array(
						'label'     => Mage::helper('libidoorder')->__('Currency'),
						'values'   => Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getValueArray18(),
						'name' => 'currency',
						));
						*/

				if (Mage::getSingleton("adminhtml/session")->getLibidoorderData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getLibidoorderData());
					Mage::getSingleton("adminhtml/session")->setLibidoorderData(null);
				} 
				elseif(Mage::registry("libidoorder_data")) {
				    $form->setValues(Mage::registry("libidoorder_data")->getData());
				}
				return parent::_prepareForm();
		}
}
