<?php


namespace Rishi\Emi\Api\Data;

interface CalculatorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get calculator list.
     * @return \Rishi\Emi\Api\Data\CalculatorInterface[]
     */
    public function getItems();

    /**
     * Set bank_name list.
     * @param \Rishi\Emi\Api\Data\CalculatorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
