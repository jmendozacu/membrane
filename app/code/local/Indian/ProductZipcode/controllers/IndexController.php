<?php

class Indian_ProductZipcode_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $checkIsEnable = Mage::helper('indian_product_zipcode_helper')->getProductZipcodeExtensionEnable();
        if ($checkIsEnable) {
            $successArray = array();
            $errorArray = array();
            if ($this->getRequest()->getPost('product_zipcode')) {
                $zipcodePost = trim($this->getRequest()->getPost('product_zipcode'));
                if (is_numeric($zipcodePost) && strlen($zipcodePost) == 6) {
                    $countryCodePost = trim($this->getRequest()->getPost('product_country'));
                    $paymentArray = array();
                    $codpostModel = Mage::getModel('cod/postcode')
                            ->getCollection()
                            ->addFieldToFilter('dest_country_id', $countryCodePost)
                            ->addFieldToFilter('dest_zip', $zipcodePost);
                    //echo $codpostModel->getSelect();
                    $codCount = count($codpostModel);
                    if ($codCount > 0) {
                        $paymentArray[] = 'COD Serviceable <br>';
                    }

                    $resource = Mage::getSingleton('core/resource');
                    $readConnection = $resource->getConnection('core_read');
                    $writeConnection = $resource->getConnection('core_write');
                    $tableName = $resource->getTableName('shipping_tablerate');
                    $query = "SELECT * FROM $tableName where dest_country_id ='" . $countryCodePost . "' AND  dest_zip = '" . $zipcodePost . "'";
                    //echo $query;
                    $results = $readConnection->fetchAll($query);
                    $resultcount = count($results);

                    if ($resultcount > 0) {
                        $paymentArray[] = 'Online Payment Available';
                    }

                    if (count($paymentArray) > 0) {
                        $successArray['successmessage'] = $paymentArray;
                        echo json_encode($successArray);
                    } else {
                        $errorArray['errormessage'] = "No Payment Method Available";
                        echo json_encode($errorArray);
                    }
                } else {
                    $errorArray['errormessage'] = "Zipcode must be numeric and must be 6 digits without space";
                    echo json_encode($errorArray);
                }
            } else {
                $errorArray['errormessage'] = "Zipcode is empty";
                echo json_encode($errorArray);
            }
        }
    }

}
