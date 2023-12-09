<?php
declare(strict_types=1);

namespace Hikmadh\DocUploader\Controller\Adminhtml\Document;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Hikmadh\DocUploader\Model\ResourceModel\Document\CollectionFactory;
use Hikmadh\DocUploader\Model\DocumentFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var DocumentFactory
     */
    protected $DocumentFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param DocumentFactory $DocumentFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        DocumentFactory $documentFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->documentFactory = $documentFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item){
            $DocumentIds[] = $item->getData('Document_id');
        }
        foreach ($DocumentIds as $DocumentId) {
            try{           
            $DocumentModel = $this->documentFactory->create();
            $DocumentModel->load($DocumentId);
            $DocumentModel->delete();
        }catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        }
        if ($collectionSize) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}