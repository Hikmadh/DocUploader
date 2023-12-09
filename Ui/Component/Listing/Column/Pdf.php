<?php
namespace Hikmadh\DocUploader\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\FormKey;

class Email extends Column
{

    private $urlBuilder;
    private $formKey;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        FormKey $formKey,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->formKey = $formKey;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name . '_html'] = "<button class='button'><span>".__("Send Email")."</span></button>";
                    $item[$name . '_title'] = __('Send  Email');
                    $item[$name . '_entity_id'] = $item['entity_id'];
                    $item[$name . '_code'] = $item['code'];
                    $item[$name . '_link_one'] = $item['link_one'];
                    $item[$name . '_link_two'] = $item['link_two'];
                    
                }
            }
        }
        return $dataSource;
    }
}