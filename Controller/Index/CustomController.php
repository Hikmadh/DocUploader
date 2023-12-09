<?php
namespace Hikmadh\DocUploader\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class CustomController extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * CustomController constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('File upload'));
        return $resultPage;
    }

    public function postAction()
    {
        $data = $this->getRequest()->getPostValue();
        $uploader = $this->getRequest()->getFiles('File');

        // Validate uploaded file
        if (isset($uploader) && $uploader['size'] > 0) {
            try {
                $uploaderDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('File');
                $uploaderName = $uploader['name'];
                $uploader->move($uploaderDirectory, $uploaderName);
                $this->messageManager->addSuccessMessage(__('File uploaded successfully.'));
                return $this->_redirect('hikmadh_DocUploader/index/customcontroller');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while uploading the file.'));
                return $this->_redirect('hikmadh_DocUploader/index/customcontroller');
            }
        } else {
            $this->messageManager->addErrorMessage(__('Please upload a file.'));
            return $this->_redirect('hikmadh_DocUploader/index/customcontroller');
        }
    }
}
