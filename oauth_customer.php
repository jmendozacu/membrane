<?php
require_once 'app/Mage.php';
Mage::app();

echo Mage::getModel('core/date')->date('Y-m-d H:i:s');