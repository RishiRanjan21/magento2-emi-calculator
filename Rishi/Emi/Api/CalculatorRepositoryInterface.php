<?php


namespace Rishi\Emi\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CalculatorRepositoryInterface
{

    /**
     * Save calculator
     * @param \Rishi\Emi\Api\Data\CalculatorInterface $calculator
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Rishi\Emi\Api\Data\CalculatorInterface $calculator
    );

    /**
     * Retrieve calculator
     * @param string $calculatorId
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($calculatorId);

    /**
     * Retrieve calculator matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Rishi\Emi\Api\Data\CalculatorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete calculator
     * @param \Rishi\Emi\Api\Data\CalculatorInterface $calculator
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Rishi\Emi\Api\Data\CalculatorInterface $calculator
    );

    /**
     * Delete calculator by ID
     * @param string $calculatorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($calculatorId);
}
