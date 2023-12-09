<?php
namespace Hikmadh\DocUploader\Controller\Adminhtml\Document;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Hikmadh\DocUploader\Model\DocumentFactory;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var DocumentFactory
     */
    protected $documentFactory;

    /**
     * @param Context $context
     * @param DocumentFactory $documentFactory
     */
    public function __construct(
        Context $context,
        DocumentFactory $documentFactory
    ) {
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
        $DocumentId = $this->getRequest()->getParam('id');
        if ($DocumentId) {
            try {
                $DocumentModel = $this->documentFactory->create();
                $DocumentModel->load($DocumentId);
                $DocumentModel->delete();
                $this->messageManager->addSuccess(__('Item has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        } else {
            $this->messageManager->addError(__('Item not found.'));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
