<?php
namespace Hikmadh\DocUploader\Model\ResourceModel\Document;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'Hikmadh_Document_Document_collection';
	protected $_eventObject = 'Document_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Hikmadh\DocUploader\Model\Document', 'Hikmadh\DocUploader\Model\ResourceModel\Document');
		
	}

}