<?php
class Esav_Libidoorder_Model_Mysql4_Libidoorder extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("libidoorder/libidoorder", "libidoorder_id");
    }
}