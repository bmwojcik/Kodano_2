<?php

namespace Kodano\Promotions\Model\Promotions;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class ResourceModel extends AbstractDb
{
    /**
     * @param string $mainTable
     * @param string $idFieldName
     * @param Context $context
     * @param $connectionName
     */
    public function __construct(
        protected string $mainTable,
        protected string $idFieldName,
        Context          $context,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init($this->mainTable, $this->idFieldName);
        $this->_useIsObjectNew = true;
    }
}
