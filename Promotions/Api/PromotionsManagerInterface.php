<?php

namespace Kodano\Promotions\Api;

use Kodano\Promotions\Model\Promotions\DataModel;

interface PromotionsManagerInterface
{
    /**
     * @param string $promotions
     *
     * @return DataModel
     */
    public function savePromotions(string $promotionsName): DataModel;

    /**
     * @param string $promotionsGroupName
     *
     * @return DataModel
     */
    public function savePromotionsGroup(string $promotionsGroupName): DataModel;

    /**
     * @return array
     */
    public function getAllPromotions(): array;

    /**
     * @return array
     */
    public function getAllPromotionsGroup(): array;
    /**
     * @param int $promotionsId
     * @param int $promotionsGroupId
     *
     * @return bool
     */
    public function assignPromotionsToGroup(int $promotionsId, int $promotionsGroupId): bool;

    /**
     * @param int $groupId
     *
     * @return array
     */
    public function getPromotionsByGroupId(int $groupId): array;

    /**
     * @param int $promotionsId
     *
     * @return array
     */
    public function getGroupsByPromotionsId(int $promotionsId): array;
}
