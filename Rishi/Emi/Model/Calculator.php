<?php


namespace Rishi\Emi\Model;

use Rishi\Emi\Api\Data\CalculatorInterfaceFactory;
use Rishi\Emi\Api\Data\CalculatorInterface;
use Magento\Framework\Api\DataObjectHelper;

class Calculator extends \Magento\Framework\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $calculatorDataFactory;

    protected $_eventPrefix = 'rishi_emi_calculator';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CalculatorInterfaceFactory $calculatorDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Rishi\Emi\Model\ResourceModel\Calculator $resource
     * @param \Rishi\Emi\Model\ResourceModel\Calculator\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CalculatorInterfaceFactory $calculatorDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Rishi\Emi\Model\ResourceModel\Calculator $resource,
        \Rishi\Emi\Model\ResourceModel\Calculator\Collection $resourceCollection,
        array $data = []
    ) {
        $this->calculatorDataFactory = $calculatorDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve calculator model with calculator data
     * @return CalculatorInterface
     */
    public function getDataModel()
    {
        $calculatorData = $this->getData();
        
        $calculatorDataObject = $this->calculatorDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $calculatorDataObject,
            $calculatorData,
            CalculatorInterface::class
        );
        
        return $calculatorDataObject;
    }
}
