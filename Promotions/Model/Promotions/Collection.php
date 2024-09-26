<?php

declare(strict_types=1);

namespace Kodano\Promotions\Model\Promotions;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface as Logger;

class Collection extends AbstractCollection
{
    /**
     * @param AbstractExtensibleModel $model
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param AbstractDb|null $resource
     * @param AdapterInterface|null $connection
     * @param string $itemObjectClass
     */
    public function __construct(
        AbstractExtensibleModel $model,
        EntityFactory           $entityFactory,
        Logger                  $logger,
        FetchStrategy           $fetchStrategy,
        EventManager            $eventManager,
        AbstractDb              $resource = null,
        AdapterInterface $connection = null,
        string           $itemObjectClass = ''
    )
    {
        $this->_model = $model;
        $this->_resource = $resource;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_itemObjectClass = $itemObjectClass;
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_idFieldName = $this->_model->getIdFieldName();
        $this->_init($this->_model::class, $this->_resource::class);
    }
}
