<?php

namespace Hikmadh\DocUploader\Block\Frontend;

use Magento\Framework\View\Element\Template;

class DocumentForm extends Template
{
    public function getFormAction()
    {
        return $this->getUrl('hikmadh_DocUploader/index/submit', ['_secure' => true]);
    }
}
