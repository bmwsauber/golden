<?php

class Esav_Libidoorder_Adminhtml_LibidoorderController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("libidoorder/libidoorder")->_addBreadcrumb(Mage::helper("adminhtml")->__("Libidoorder  Manager"),Mage::helper("adminhtml")->__("Libidoorder Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Libidoorder"));
			    $this->_title($this->__("Manager Libidoorder"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Libidoorder"));
				$this->_title($this->__("Libidoorder"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("libidoorder/libidoorder")->load($id);
				if ($model->getId()) {
					Mage::register("libidoorder_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("libidoorder/libidoorder");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Libidoorder Manager"), Mage::helper("adminhtml")->__("Libidoorder Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Libidoorder Description"), Mage::helper("adminhtml")->__("Libidoorder Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("libidoorder/adminhtml_libidoorder_edit"))->_addLeft($this->getLayout()->createBlock("libidoorder/adminhtml_libidoorder_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("libidoorder")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Libidoorder"));
		$this->_title($this->__("Libidoorder"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("libidoorder/libidoorder")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("libidoorder_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("libidoorder/libidoorder");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Libidoorder Manager"), Mage::helper("adminhtml")->__("Libidoorder Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Libidoorder Description"), Mage::helper("adminhtml")->__("Libidoorder Description"));


		$this->_addContent($this->getLayout()->createBlock("libidoorder/adminhtml_libidoorder_edit"))->_addLeft($this->getLayout()->createBlock("libidoorder/adminhtml_libidoorder_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						$model = Mage::getModel("libidoorder/libidoorder")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Libidoorder was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setLibidoorderData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setLibidoorderData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("libidoorder/libidoorder");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('ibidoorder_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("libidoorder/libidoorder");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'libidoorder.csv';
			$grid       = $this->getLayout()->createBlock('libidoorder/adminhtml_libidoorder_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		}
}
