<?php


namespace Rishi\Emi\Model\Data;

use Rishi\Emi\Api\Data\CalculatorInterface;

class Calculator extends \Magento\Framework\Api\AbstractExtensibleObject implements CalculatorInterface
{

    /**
     * Get calculator_id
     * @return string|null
     */
    public function getCalculatorId()
    {
        return $this->_get(self::CALCULATOR_ID);
    }

    /**
     * Set calculator_id
     * @param string $calculatorId
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setCalculatorId($calculatorId)
    {
        return $this->setData(self::CALCULATOR_ID, $calculatorId);
    }

    /**
     * Get bank_name
     * @return string|null
     */
    public function getBankName()
    {
        return $this->_get(self::BANK_NAME);
    }

    /**
     * Set bank_name
     * @param string $bankName
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setBankName($bankName)
    {
        return $this->setData(self::BANK_NAME, $bankName);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Rishi\Emi\Api\Data\CalculatorExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Rishi\Emi\Api\Data\CalculatorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Rishi\Emi\Api\Data\CalculatorExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get term_conditions
     * @return string|null
     */
    public function getTermConditions()
    {
        return $this->_get(self::TERM_CONDITIONS);
    }

    /**
     * Set term_conditions
     * @param string $termConditions
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setTermConditions($termConditions)
    {
        return $this->setData(self::TERM_CONDITIONS, $termConditions);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get modified_at
     * @return string|null
     */
    public function getModifiedAt()
    {
        return $this->_get(self::MODIFIED_AT);
    }

    /**
     * Set modified_at
     * @param string $modifiedAt
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setModifiedAt($modifiedAt)
    {
        return $this->setData(self::MODIFIED_AT, $modifiedAt);
    }

    /**
     * Get emi_tenure
     * @return string|null
     */
    public function getEmiTenure()
    {
        return $this->_get(self::EMI_TENURE);
    }

    /**
     * Set emi_tenure
     * @param string $emiTenure
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setEmiTenure($emiTenure)
    {
        return $this->setData(self::EMI_TENURE, $emiTenure);
    }

    /**
     * Get interest_rate
     * @return string|null
     */
    public function getInterestRate()
    {
        return $this->_get(self::INTEREST_RATE);
    }

    /**
     * Set interest_rate
     * @param string $interestRate
     * @return \Rishi\Emi\Api\Data\CalculatorInterface
     */
    public function setInterestRate($interestRate)
    {
        return $this->setData(self::INTEREST_RATE, $interestRate);
    }
}
