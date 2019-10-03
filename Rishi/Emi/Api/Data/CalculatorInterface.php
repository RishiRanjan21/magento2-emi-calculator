<?php


namespace Rishi\Emi\Api\Data;

interface CalculatorInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const TERM_CONDITIONS = 'term_conditions';
    const CREATED_AT = 'created_at';
    const EMI_TENURE = 'emi_tenure';
    const INTEREST_RATE = 'interest_rate';
    const BANK_NAME = 'bank_name';
    const MODIFIED_AT = 'modified_at';
    const STATUS = 'status';
    const CALCULATOR_ID = 'calculator_id';

    /**
     * Get calculator_id
     * @return string|null
     */
    public function getCalculatorId();

    /**
     * Set calculator_id
     * @param string $calculatorId
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setCalculatorId($calculatorId);

    /**
     * Get bank_name
     * @return string|null
     */
    public function getBankName();

    /**
     * Set bank_name
     * @param string $bankName
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setBankName($bankName);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Rishi\Emi\Api\Data\CalculatorExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Rishi\Emi\Api\Data\CalculatorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Rishi\Emi\Api\Data\CalculatorExtensionInterface $extensionAttributes
    );

    /**
     * Get term_conditions
     * @return string|null
     */
    public function getTermConditions();

    /**
     * Set term_conditions
     * @param string $termConditions
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setTermConditions($termConditions);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setStatus($status);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get modified_at
     * @return string|null
     */
    public function getModifiedAt();

    /**
     * Set modified_at
     * @param string $modifiedAt
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get emi_tenure
     * @return string|null
     */
    public function getEmiTenure();

    /**
     * Set emi_tenure
     * @param string $emiTenure
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setEmiTenure($emiTenure);

    /**
     * Get interest_rate
     * @return string|null
     */
    public function getInterestRate();

    /**
     * Set interest_rate
     * @param string $interestRate
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setInterestRate($interestRate);
}
