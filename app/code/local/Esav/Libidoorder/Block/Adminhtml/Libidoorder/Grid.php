<?php

class Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("libidoorderGrid");
				$this->setDefaultSort("libidoorder_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("libidoorder/libidoorder")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
		/*
				$this->addColumn("libidoorder_id", array(
				"header" => Mage::helper("libidoorder")->__("ID"),
				"align" =>"right",
				"width" => "30px",
			    "type" => "number",
				"index" => "libidoorder_id",
				));
          */      
				$this->addColumn("libidoorder_id", array(
				"header" => Mage::helper("libidoorder")->__("ID"),
				"index" => "libidoorder_id",
				));
				$this->addColumn("product_sku", array(
				"header" => Mage::helper("libidoorder")->__("product SKU"),
				"width" => "60px",
				"index" => "product_sku",
				));
				
				$this->addColumn('created_at', array(
					'header'    => Mage::helper('libidoorder')->__('Created at'),
					'index'     => 'created_at',
					'type'      => 'datetime',
				));
				$this->addColumn("name", array(
				"header" => Mage::helper("libidoorder")->__("Name"),
				"index" => "name",
				));
				/*
				$this->addColumn("last_name", array(
				"header" => Mage::helper("libidoorder")->__("Last name"),
				"index" => "last_name",
				));
				*/
				$this->addColumn("email", array(
				"header" => Mage::helper("libidoorder")->__("E-mail"),
				"index" => "email",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("libidoorder")->__("Mobile number"),
				"index" => "mobile",
				));
				$this->addColumn("address", array(
				"header" => Mage::helper("libidoorder")->__("Address"),
				"index" => "address",
				));
				$this->addColumn("zipcode", array(
				"header" => Mage::helper("libidoorder")->__("Zipcode / City"),
				"index" => "zipcode",
				));
				$this->addColumn('country', array(
				'header' => Mage::helper('libidoorder')->__('Country'),
				'index' => 'country',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray8(),				
				));
				$this->addColumn("qty", array(
				"header" => Mage::helper("libidoorder")->__("Qty"),
				"index" => "qty",
				));
				
				$this->addColumn("sum", array(
				"header" => Mage::helper("libidoorder")->__("Sum"),
				"index" => "sum",
				));
				$this->addColumn('use_this_address_for_delivery', array(
				'header' => Mage::helper('libidoorder')->__('Use this address for delivery'),
				'index' => 'use_this_address_for_delivery',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray11(),				
				));
				
				$this->addColumn('newsletter', array(
				'header' => Mage::helper('libidoorder')->__('Receive newsletter'),
				'index' => 'newsletter',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray12(),				
				));
				/*
				$this->addColumn('monthly_shipments', array(
				'header' => Mage::helper('libidoorder')->__('Monthly shipments'),
				'index' => 'monthly_shipments',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray13(),				
				));
				
				$this->addColumn('both_products_every_month', array(
				'header' => Mage::helper('libidoorder')->__('User pays and gets both products every month.'),
				'index' => 'both_products_every_month',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray14(),				
				));
				
				$this->addColumn("qty_per_month", array(
				"header" => Mage::helper("libidoorder")->__("Qty per month"),
				"index" => "qty_per_month",
				));
				*/				
				
				/*
				$this->addColumn("how_many_months", array(
				"header" => Mage::helper("libidoorder")->__("How many months"),
				"index" => "how_many_months",
				));
				*/
				$this->addColumn("location", array(
				"header" => Mage::helper("libidoorder")->__("Location"),
				"index" => "location",
				));
				/*
				$this->addColumn('currency', array(
				'header' => Mage::helper('libidoorder')->__('Currency'),
				'index' => 'currency',
				'type' => 'options',
				'options'=>Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray18(),				
				));
				*/
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('libidoorder_id');
			$this->getMassactionBlock()->setFormFieldName('libidoorder_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_libidoorder', array(
					 'label'=> Mage::helper('libidoorder')->__('Remove Libidoorder'),
					 'url'  => $this->getUrl('*/adminhtml_libidoorder/massRemove'),
					 'confirm' => Mage::helper('libidoorder')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray8()
		{
            $data_array=array(); 
			$data_array[0]='norway';
			$data_array[1]='sweden';
			$data_array[2]='uk';
			$data_array[3]='denmark';
			$data_array[4]='usa';
			$data_array[5]='germany';
			$data_array[6]='poland';
            return($data_array);
		}
		static public function getValueArray8()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray8() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray11()
		{
            $data_array=array(); 
			$data_array[0]='No';
			$data_array[1]='Yes';
            return($data_array);
		}
		static public function getValueArray11()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray11() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray12()
		{
            $data_array=array(); 
			$data_array[0]='No';
			$data_array[1]='Yes';
            return($data_array);
		}
		static public function getValueArray12()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray12() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray13()
		{
            $data_array=array(); 
			$data_array[0]='No';
			$data_array[1]='Yes';
            return($data_array);
		}
		static public function getValueArray13()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray13() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray14()
		{
            $data_array=array(); 
			$data_array[0]='No';
			$data_array[1]='Yes';
            return($data_array);
		}
		static public function getValueArray14()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray14() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray18()
		{
            $data_array=array(); 
			$data_array[0]='Danish Kroner (DKK) ';
			$data_array[1]='Euro (EUR) ';
			$data_array[2]='US Dollar $ (USD) ';
			$data_array[3]='Norwegian Kroner (NOK) ';
			$data_array[4]='Swiss Franc (CHF) ';
			$data_array[5]='English Pound £ (GBP) ';
            return($data_array);
		}
		static public function getValueArray18()
		{
            $data_array=array();
			foreach(Esav_Libidoorder_Block_Adminhtml_Libidoorder_Grid::getOptionArray18() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}