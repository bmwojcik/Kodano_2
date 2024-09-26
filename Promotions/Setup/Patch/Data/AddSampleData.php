<?php

declare(strict_types=1);

namespace Kodano\Promotions\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddSampleData implements DataPatchInterface, PatchRevertableInterface
{
    public const KODANO_PROMOTIONS_TABLE_NAME = 'kodano_promotions';
    public const KODANO_PROMOTIONS_GROUP_TABLE_NAME = 'kodano_promotions_group';
    public const KODANO_PROMOTIONS_GROUP_RELATION_TABLE_NAME = 'kodano_promotions_group_relation';

    public const TABLES_ENTITY_ID = 'entity_id';

    private const SAMPLE_DATA = [
        self::KODANO_PROMOTIONS_TABLE_NAME => [
            ['name' => 'Shoes'],
            ['name' => 'Jackets'],
            ['name' => 'Computer'],
            ['name' => 'Glasses']
        ],
        self::KODANO_PROMOTIONS_GROUP_TABLE_NAME => [
            ['name' => 'Clothes'],
            ['name' => 'Electronic'],
            ['name' => 'Gadgets']
        ],
        self::KODANO_PROMOTIONS_GROUP_RELATION_TABLE_NAME  => [
            ['promotions_id' => 1, 'group_id' => 1],
            ['promotions_id' => 1, 'group_id' => 2],
            ['promotions_id' => 2, 'group_id' => 2],
            ['promotions_id' => 3, 'group_id' => 2],
        ]
    ];

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup
    )
    {
    }

    /** @inheritdoc */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        foreach (self::SAMPLE_DATA as $tableName => $sampleData) {
            $this->moduleDataSetup->getConnection()->insertMultiple(
                $this->moduleDataSetup->getTable($tableName),
                $sampleData
            );
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /** @inheritdoc */
    public static function getDependencies(): array
    {
        return [];
    }

    /** @inheritdoc */
    public function getAliases(): array
    {
        return [];
    }

    /** @inheritdoc */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        foreach (self::SAMPLE_DATA as $tableName => $sampleData) {
            $nameValues = array_column($sampleData, 'name');

            if (!empty($nameValues)) {
                $this->moduleDataSetup->getConnection()->delete(
                    $this->moduleDataSetup->getTable($tableName),
                    ['name IN (?)' => $nameValues]
                );
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
