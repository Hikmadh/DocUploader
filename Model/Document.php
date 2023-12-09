<?php
namespace Hikmadh\DocUploader\Model;
class Document extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'hikmadh_Document_Document';

	protected $_cacheTag = 'hikmadh_menu_Document';

	protected $_eventPrefix = 'hikmadh_menu_Document';

	protected function _construct()
	{
		$this->_init('Hikmadh\DocUploader\Model\ResourceModel\Document');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
	
}