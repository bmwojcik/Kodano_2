<?php

namespace Kodano\Promotions\Api\Repository;

use Kodano\Promotions\Model\Promotions\DataModel;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface RepositoryInterface
{
    /**
     * @param DataModel $promotions
     *
     * @return DataModel
     */
    public function save(DataModel $promotions): DataModel;

    /**
     * @param int $promotionsId
     *
     * @return DataModel
     */
    public function getById(int $promotionsId): DataModel;

    /**
     * @param DataModel $promotions
     *
     * @return bool
     */
    public function delete(DataModel $promotions): bool;

    /**
     * @param int $promotionsId
     * @return bool
     *
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function deleteById(int $promotionsId): bool;

    /**
     * @param SearchCriteriaInterface | null $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(?SearchCriteriaInterface $searchCriteria = null): \Magento\Framework\Api\SearchResultsInterface;
}
