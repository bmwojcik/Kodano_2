<?php
declare(strict_types=1);

namespace Kodano\Promotions\Model\Promotions;

use Kodano\Promotions\Api\Repository\RepositoryInterface;
use Kodano\Promotions\Model\Promotions\CollectionFactory as CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class Repository implements RepositoryInterface
{
    /**
     * @param Collection $collection
     * @param ResourceModel $resourceModel
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsFactory $searchResultFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private Collection    $collection,
        private ResourceModel $resourceModel,
        private CollectionProcessorInterface $collectionProcessor,
        private SearchResultsFactory         $searchResultFactory,
        private SearchCriteriaBuilder        $searchCriteriaBuilder
    )
    {
    }

    /** @inheritdoc */
    public function save(DataModel $promotions): DataModel
    {
        try {
            $this->resourceModel->save($promotions);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $promotions;
    }

    /** @inheritdoc */
    public function getById(int $promotionsId): DataModel
    {
        $promotions = $this->collection->getItemById($promotionsId);
        if (!$promotions) {
            throw new NoSuchEntityException(__('Promotion with id "%1" does not exist.', $promotionsId));
        }

        return $promotions;
    }

    /** @inheritdoc */
    public function delete(DataModel $promotions): bool
    {
        try {
            $this->resourceModel->delete($promotions);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /** @inheritdoc */
    public function deleteById(int $promotionsId): bool
    {
        return $this->delete($this->getById($promotionsId));
    }

    /** @inheritdoc */
    public function getList(?SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collection;

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        /** @var SearchResults $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
