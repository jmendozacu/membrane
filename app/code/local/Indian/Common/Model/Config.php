<?php

/**
 * Rewrite Magento Default  Sort By Option On Catgory Page
 *
 * @category   Rewrite Magento Default  Sort By Option On Catgory Page
 * @author     Vishal Patel
 * @copyright  ©2016 Indian. All Rights Reserved  
 * @version    0.0.1
 */
class Indian_Common_Model_Config extends Mage_Catalog_Model_Config {

    /**
     * Rewrite Magento Default  Sort By Option On Catgory Page
     *
     * @category   Rewrite Magento Default  Sort By Option On Catgory Page
     * @author     Vishal Patel
     * @copyright  ©2016 Indian. All Rights Reserved  
     * @version    0.0.1
     * @description Add Aditional "Updated At" Sort By.
     */ 
    public function getAttributeUsedForSortByArray()
    {
        $options = array(
            'position'  => Mage::helper('catalog')->__('Recommend'),
            'created_at'  => Mage::helper('catalog')->__('Most Recent')
        );
        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute_Abstract */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }

        return $options;
    }

}
