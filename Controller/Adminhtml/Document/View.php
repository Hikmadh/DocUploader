<?php

namespace Hikmadh\DocUploader\Controller\Adminhtml\Document;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Hikmadh\DocUploader\Model\DocumentFactory;

class View extends Action
{
    /**
     * @var PrescFactory
     */
    private $documentFactory;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * View constructor.
     * @param Action\Context $context
     * @param DocumentFactory $documentFactory
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Action\Context $context,
        DocumentFactory $documentFactory,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->documentFactory = $documentFactory;
        $this->fileFactory = $fileFactory;
    }

    /**
     * Controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            $document = $this->documentFactory->create()->load($id); 
            
            $fileName = $document->getData('Document');
            
            $response = $this->fileFactory->create(
    $fileName,
    [
        'type' => 'filename',
        'value' => 'pub/media/uploads/' . $fileName,
    ]
);        
            return $response;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while retrieving the File.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }
    }
}
