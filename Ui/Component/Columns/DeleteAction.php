<?php

namespace Hikmadh\DocUploader\Ui\Component\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Hikmadh\DocUploader\Model\DocFactory;

class DeleteAction extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            $fieldName = $this->getData("name");
            foreach ($dataSource["data"]["items"] as $key => $item) {
                $itemId = $item['Document_id'];
                $url = $this->urlBuilder->getUrl('hikmadh_DocUploader/document/Delete', ['id' => $itemId]);

                $html = "<a href='{$url}' onclick='openPopup(event);'>Delete</a>";
                $dataSource["data"]["items"][$key][$fieldName] = $html;
            }
        }

        return $dataSource;
    }
}
