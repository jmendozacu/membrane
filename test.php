<?php
require_once 'app/Mage.php';
Mage::app();

echo Mage::getModel('core/date')->date('Y-m-d H:i:s');

$layer = Mage::getModel("catalog/layer");
//foreach($categories as $categoryid) {
    $category = Mage::getModel("catalog/category")->load(4);
    $layer->setCurrentCategory($category);
    $attributes = $layer->getFilterableAttributes();
    

    foreach ($attributes as $attribute) {
        if ($attribute->getAttributeCode() == 'price') {
            $filterBlockName = 'catalog/layer_filter_price';
        } elseif ($attribute->getBackendType() == 'decimal') {
            $filterBlockName = 'catalog/layer_filter_decimal';
        } else {
            $filterBlockName = 'catalog/layer_filter_attribute';
        }

        $result = Mage::app()->getLayout()->createBlock($filterBlockName)->setLayer($layer)->setAttributeModel($attribute)->init();
        var_dump($result->getItems());
        
        foreach($result->getItems() as $option) {
            echo $option->getLabel().'<br/>';
            echo $option->getValue();
        }
}