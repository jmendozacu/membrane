<?php 


class Indian_CodImportExport_Model_Mysql4_Postcode extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('cod/postcode', 'pk');
    }

}
