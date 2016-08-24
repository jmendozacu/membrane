<?php
class Indian_Common_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
    protected $_direction           = 'desc';
    
    public function setDefaultOrder($field)
    {
        $field = 'created_at';
        if (isset($this->_availableOrder[$field])) {
            $this->_orderField = $field;
        }
        return $this;
    }
}
