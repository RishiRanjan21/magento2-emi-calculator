<?php


namespace Rishi\Emi\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Rishi\Emi\Model\ResourceModel\Calculator as ResourceCalculator;
use Magento\Framework\Reflection\DataObjectProcessor;
use Rishi\Emi\Api\Data\CalculatorInterfaceFactory;
use Rishi\Emi\Api\Data\CalculatorSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Rishi\Emi\Api\CalculatorRepositoryInterface;
use Rishi\Emi\Model\ResourceModel\Calculator\CollectionFactory as CalculatorCollectionFactory;

class CalculatorRepository implements CalculatorRepositoryInterface
{

    private $collectionProcessor;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $extensibleDataObjectConverter;
    protected $extensionAttributesJoinProcessor;

    protected $dataObjectHelper;

    protected $resource;

    protected $dataCalculatorFactory;

    protected $calculatorFactory;

    private $storeManager;

    protected $calculatorCollectionFactory;


    /**
     * @param ResourceCalculator $resource
     * @param CalculatorFactory $calculatorFactory
     * @param CalculatorInterfaceFactory $dataCalculatorFactory
     * @param CalculatorCollectionFactory $calculatorCollectionFactory
     * @param CalculatorSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceCalculator $resource,
        CalculatorFactory $calculatorFactory,
        CalculatorInterfaceFactory $dataCalculatorFactory,
        CalculatorCollectionFactory $calculatorCollectionFactory,
        CalculatorSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->calculatorFactory = $calculatorFactory;
        $this->calculatorCollectionFactory = $calculatorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCalculatorFactory = $dataCalculatorFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Rishi\Emi\Api\Data\CalculatorInterface $calculator
    ) {
        /* if (empty($calculator->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $calculator->setStoreId($storeId);
        } */
        
        $calculatorData = $this->extensibleDataObjectConverter->toNestedArray(
            $calculator,
            [],
            \Rishi\Emi\Api\Data\CalculatorInterface::class
        );
        
        $calculatorModel = $this->calculatorFactory->create()->setData($calculatorData);
        
        try {
            $this->resource->save($calculatorModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the EMI Calculator: %1',
                $exception->getMessage()
            ));
        }
        return $calculatorModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($calculatorId)
    {
        $calculator = $this->calculatorFactory->create();
        $this->resource->load($calculator, $calculatorId);
        if (!$calculator->getId()) {
            throw new NoSuchEntityException(__('EMI Calculator with id "%1" does not exist.', $calculatorId));
        }
        return $calculator->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->calculatorCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Rishi\Emi\Api\Data\CalculatorInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Rishi\Emi\Api\Data\CalculatorInterface $calculator
    ) {
        try {
            $calculatorModel = $this->calculatorFactory->create();
            $this->resource->load($calculatorModel, $calculator->getCalculatorId());
            $this->resource->delete($calculatorModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the EMI Calculator: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($calculatorId)
    {
        return $this->delete($this->getById($calculatorId));
    }
}
