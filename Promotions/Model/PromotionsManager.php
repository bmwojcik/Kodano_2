<?php
declare(strict_types=1);

namespace Kodano\Promotions\Model;

use Kodano\Promotions\Api\PromotionsManagerInterface;
use Kodano\Promotions\Model\Promotions\DataModel;
use Kodano\Promotions\Model\Promotions\DataModelFactory;
use Kodano\Promotions\Model\Promotions\Repository;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Api\SearchCriteriaBuilder;

class PromotionsManager implements PromotionsManagerInterface
{
    /**
     * @param DataModelFactory $promotionsRelationDataModelFactory
     * @param DataModelFactory $promotionsDataModelFactory
     * @param DataModelFactory $promotionsGroupDataModelFactory
     * @param Repository $promotionsRepository
     * @param Repository $promotionsGroupRepository
     * @param Repository $promotionsRelationRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private DataModelFactory  $promotionsRelationDataModelFactory,
        private DataModelFactory  $promotionsDataModelFactory,
        private DataModelFactory  $promotionsGroupDataModelFactory,
        private Repository $promotionsRepository,
        private Repository $promotionsGroupRepository,
        private Repository $promotionsRelationRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    /** @inheritdoc */
    public function savePromotions(string $promotionsName): DataModel
    {
        $promotions = $this->promotionsDataModelFactory->create();
        $promotions->setName($promotionsName);

        return $this->promotionsRepository->save($promotions);
    }

    /** @inheritdoc */
    public function savePromotionsGroup(string $promotionsGroupName): DataModel
    {
        $promotions = $this->promotionsGroupDataModelFactory->create();
        $promotions->setName($promotionsGroupName);

        return $this->promotionsGroupRepository->save($promotions);

    }

    /** @inheritdoc */
    public function getAllPromotions(): array
    {
        return $this->promotionsRepository->getList()->getItems();
    }

    /** @inheritdoc */
    public function getAllPromotionsGroup(): array
    {
        return $this->promotionsGroupRepository->getList()->getItems();
    }

    /** @inheritdoc */
    public function assignPromotionsToGroup(int $promotionsId, int $promotionsGroupId): bool
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('promotions_id', $promotionsId)
            ->addFilter('group_id', $promotionsGroupId)
            ->create();

        $result = $this->promotionsRelationRepository->getList($searchCriteria);

        if ($result->getTotalCount() > 0) {
            throw new AlreadyExistsException(
                __('The promotion with ID "%1" is already assigned to the group with ID "%2".', $promotionsId, $promotionsGroupId)
            );
        }

        /** @var DataModel $relation */
        $relation = $this->promotionsRelationDataModelFactory->create();
        $relation->setPromotionsId((string)$promotionsId);
        $relation->setGroupId((string)$promotionsGroupId);

        $this->promotionsRelationRepository->save($relation);

        return true;
    }

    /** @inheritdoc */
    public function getPromotionsByGroupId(int $groupId): array
    {
        $this->searchCriteriaBuilder->addFilter('group_id', $groupId);
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $result = $this->promotionsRelationRepository->getList($searchCriteria)->getItems();

        return array_map(function ($relation) {
            return $relation->getPromotionName();
        }, $result);
    }

    /** @inheritdoc */
    public function getGroupsByPromotionsId(int $promotionsId): array
    {
        $this->searchCriteriaBuilder->addFilter('promotions_id', $promotionsId);
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $result = $this->promotionsRelationRepository->getList($searchCriteria)->getItems();

        return array_map(function ($relation) {
            return $relation->getGroupName();
        }, $result);
    }
}
