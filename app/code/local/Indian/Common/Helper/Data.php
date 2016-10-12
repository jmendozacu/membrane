<?php

/**
 * Indian Common Module
 *
 * @category   Common Code For Full Website
 * @author     Vishal Patel
 * @copyright  ©2016 Indian. All Rights Reserved  
 * @version    0.0.1
 */
class Indian_Common_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Product Discount Calculation
     *
     * @category   Product Discount Calculation
     * @author     Vishal Patel
     * @copyright  ©2016 Admyrin. All Rights Reserved  
     * @version    0.0.1
     */
    public function productDiscount($_product) {
        return number_format((($_product->getPrice() - $_product->getSpecialPrice()) * 100) / $_product->getPrice());
    }

    /**
     * Custom Format String Function
     *
     * @category   Custom Format String Function
     * @author     Vishal Patel
     * @copyright  ©2016 Admyrin. All Rights Reserved  
     * @version    0.0.1
     */
    public function formatString($string, $length) {

        return (strlen($string) > $length) ? substr($string, 0, $length - 2) . '...' : $string;
    }

}
