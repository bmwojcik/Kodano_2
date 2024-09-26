<?php
declare(strict_types=1);

namespace Kodano\Promotions\Model\Promotions\Relations;

use Kodano\Promotions\Model\Promotions\Collection as BaseCollection;
use Kodano\Promotions\Setup\Patch\Data\AddSampleData;

class Collection extends BaseCollection
{
    /**
     * @return void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->joinPromotionsTable();
        $this->joinPromotionsGroupTable();
    }

    /**
     * @return $this
     */
    public function joinPromotionsTable(): self
    {
        $this->getSelect()->joinLeft(
            ['promotions' => $this->getTable(AddSampleData::KODANO_PROMOTIONS_TABLE_NAME)],
            'main_table.promotions_id = promotions.entity_id',
            ['promotion_name' => 'promotions.name']
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function joinPromotionsGroupTable(): self
    {
        $this->getSelect()->joinLeft(
            ['promotions_group' => $this->getTable(AddSampleData::KODANO_PROMOTIONS_GROUP_TABLE_NAME)],
            'main_table.group_id = promotions_group.entity_id',
            ['group_name' => 'promotions_group.name']
        );

        return $this;
    }
}
