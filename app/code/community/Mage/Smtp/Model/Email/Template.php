<?php

class Mage_Smtp_Model_Email_Template extends Mage_Core_Model_Email_Template {

    public function send($email, $name = null, array $variables = array()) {
        if (!Mage::getStoreConfig('smtp/settings/enabled')) {
            return parent::send($email, $name, $variables);
        }
        if (!$this->isValidForSend()) {
            return false;
        }

        if (is_null($name)) {
            $name = substr($email, 0, strpos($email, '@'));
        }

        $variables['email'] = $email;
        $variables['name'] = $name;

        $mail = $this->getMail();
        if (is_array($email)) {
            foreach ($email as $emailOne) {

                if (is_array($name))
                    $name = $name[0];
                //var_dump($name);
                //die;
                $mail->addTo($emailOne, $name);
            }
        }
        else {
            $mail->addTo($email, $name);
        }

        $this->setUseAbsoluteLinks(true);
        $text = $this->getProcessedTemplate($variables, true);

        if ($this->isPlain()) {
            $mail->setBodyText($text);
        } else {
            $mail->setBodyHTML($text);
        }

        $mail->setSubject($this->getProcessedTemplateSubject($variables));
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());

        $transport = Mage::helper('smtp')->getTransport();
        //echo get_class($transport);
        //echo get_class($mail);
        //die;
        try {
            $mail->send($transport); // Zend_Mail warning..
            $this->_mail = null;
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

}
