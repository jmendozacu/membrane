<?php

class Indian_ProductZipcode_Helper_Data extends Mage_Core_Helper_Abstract {

    const PRODUCT_ZIPCODE_ENABLE = 'indian_product_zipcode/indian_product_zipcode_group/indian_product_zipcode_enable';

    public function getProductZipcodeExtensionEnable() {
        return (Mage::getStoreConfig(self::PRODUCT_ZIPCODE_ENABLE)) ? Mage::getStoreConfig(self::PRODUCT_ZIPCODE_ENABLE) : false;
    }

}
