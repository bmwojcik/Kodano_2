<?php

namespace Kodano\Promotions\Model\Promotions;

use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * @method string|null getName() Get the name of the promotion.
 * @method void setName(string $name) Set the name of the promotion.
 *
 * @method string|null getCreatedAt() Get the creation timestamp of the promotion.
 * @method void setCreatedAt(string $createdAt) Set the creation timestamp of the promotion.
 *
 * @method string|null getUpdatedAt() Get the update timestamp of the promotion.
 * @method void setUpdatedAt(string $updatedAt) Set the update timestamp of the promotion.
 *
 * @method string|null getPromotionsId() Get the promotions ID associated with the promotion.
 * @method void setPromotionsId(string|null $promotionsId) Set the promotions ID associated with the promotion.
 *
 * @method string|null getGroupId() Get the group ID associated with the promotion.
 * @method void setGroupId(string|null $groupId) Set the group ID associated with the promotion.
 */
class DataModel extends AbstractExtensibleModel
{
    /** @var string */
    protected $_eventPrefix;

    /** @return void  */
    protected function _construct()
    {
        $this->_init($this->_resource::class);
        $this->_eventPrefix = $this->_resource->getMainTable();
    }
}
