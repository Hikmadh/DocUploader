<?php
namespace Hikmadh\DocUploader\Controller\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Hikmadh\DocUploader\Model\DocumentFactory;
use Magento\Framework\Controller\ResultFactory; 

class Submit extends \Magento\Framework\App\Action\Action
{
    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var $DocumentFactory
     */
    protected $DocumentFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     * @param DateTime $dateTime
     * @param DocumentFactory $DocumentFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        DateTime $dateTime,
        DocumentFactory $DocumentFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->dateTime = $dateTime;
        $this->DocumentFactory = $DocumentFactory;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('checkout', ['_fragment' => 'payment']);

        $files = $this->getRequest()->getFiles();
        if (isset($files['Document']) && !empty($files['Document']["name"])) {
            try {
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'Document']);
                $uploaderFactory->setAllowedExtensions(['txt', 'pdf', 'docx', 'doc']);
                $uploaderFactory->setAllowRenameFiles(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('uploads');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('File cannot be saved to path: %1', $destinationPath)
                    );
                }
                $imagePath = $result['file'];

                // Retrieve current user name
                $customerName = $this->customerSession->getCustomer()->getName();

                // Retrieve current date and time
                $dateTime = $this->dateTime->gmtDate();

                // Save the data to the daDocUploaderase
                $DocumentModel = $this->DocumentFactory->create();
                $DocumentModel->setData([
                    'customer_name' => $customerName,
                    'Date_Time' => $dateTime,
                    'Document' => $imagePath,
                ]);
                $DocumentModel->save();

                $this->messageManager->addSuccessMessage(__('File uploaded and data saved successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('checkout', ['_fragment' => 'payment', '_query' => ['error' => '1']]);
            }
        } else {
            $this->messageManager->addErrorMessage(__('Please select a file to upload.'));
            return $resultRedirect->setPath('checkout', ['_fragment' => 'payment', '_query' => ['error' => '1']]);
        }

        return $resultRedirect;
    }
}
