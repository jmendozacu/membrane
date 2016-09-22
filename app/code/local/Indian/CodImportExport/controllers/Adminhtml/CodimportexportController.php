<?php

class Indian_CodImportExport_Adminhtml_CodimportexportController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->_setActiveMenu('indian_codimportexport/list');
        $blockdata = $this->getLayout()->createBlock('core/template')->setData('area', 'adminhtml')->setTemplate('indiancodimportexport/index.phtml');
        $this->_addContent($blockdata);
        $this->renderLayout();
    }

    public function exportAction() {
        $file = 'example.csv';
        $csv = new Varien_File_Csv();
        $csvdata = array();
        $csvdata[] = array('id' => 'Id', 'website_id' => 'Website Id', 'dest_country_id' => 'Destination Country Id', 'zip_code' => 'Zip Code');
        $codZipcodes = Mage::getModel('cod/postcode')->getCollection();

        foreach ($codZipcodes as $codZipcode) {
            $cod_data = array();
            $cod_data['id'] = $codZipcode->getPk();
            $cod_data['website_id'] = $codZipcode->getWebsiteId();
            $cod_data['dest_country_id'] = $codZipcode->getDestCountryId();
            $cod_data['zip_code'] = $codZipcode->getDestZip();
            $csvdata[] = $cod_data;
        }

        $csv->saveData($file, $csvdata);
        $this->_prepareDownloadResponse($file, array('type' => 'filename', 'value' => $file));
    }

    public function importAction() {
        $fileTrue = $this->fileImportCsvUpload();
        if ($fileTrue) {
            $file = 'var/CodImport/' . $fileTrue;

            $csv = new Varien_File_Csv();
            $data = $csv->getData($file);

            if (count($data[0] == 2) && $data[0][0] == 'Country' && $data[0][1] =='Zip/Postal Code') {
                //echo "<pre>"; print_r($data);die;
                //Mage::getResourceModel('cod/postcode')->truncate();
                $coll = Mage::getModel('cod/postcode')->getCollection();
                $tableName = $coll->getResource()->getMainTable();
                $conn = $coll->getConnection();
                $conn->truncateTable($tableName);

                $i = 1;
                foreach ($data as $value) {
                    if ($i != 1) {
                        $datacsv = array('website_id' => 1,
                            'dest_country_id' => $value[0],
                            'dest_zip' => $value[1]);
                        $model = Mage::getModel('cod/postcode')->setData($datacsv);
                        try {
                            $insertId = $model->save()->getId();
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                    $i++;
                }

                Mage::getSingleton('core/session')->addSuccess("Import success");
            } else {
                Mage::getSingleton('core/session')->addError("Import is failed.");
            }
        } else {
            Mage::getSingleton('core/session')->addError("Import is failed.");
        }

        $this->_redirect("*/*/index");
    }

    public function fileImportCsvUpload() {
        if (isset($_FILES['import_file']['name']) and ( file_exists($_FILES['import_file']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('import_file');
                $uploader->setAllowedExtensions(array('csv')); // or pdf or anything


                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                $path = Mage::getBaseDir('var') . DS . 'CodImport' . DS;
                $filename = 'cod_import_' . date('m-d-Y_h_i') . '.csv';

                $uploader->save($path, $_FILES['fileinputname']['name'] = $filename);

                $data['fileinputname'] = $_FILES['fileinputname']['name'];
                return $filename;
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError("File extension is not supported!");
            }
        }
    }

}
