<?php

declare(strict_types=1);

namespace Kodano\Promotions\Model\Promotions;

use Magento\Framework\ObjectManagerInterface;

class DataModelFactory
{
    /**
     * @param string $dataModelClassType
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        private string $dataModelClassType,
        private ObjectManagerInterface $objectManager
    ) {
    }

    /**
     * @param array $data
     *
     * @return DataModel
     */
    public function create(array $data = []): DataModel
    {
        return $this->objectManager->create($this->dataModelClassType, $data);
    }
}
