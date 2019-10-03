<?php


namespace Rishi\Emi\Model\ResourceModel\Calculator;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Rishi\Emi\Model\Calculator::class,
            \Rishi\Emi\Model\ResourceModel\Calculator::class
        );
    }
}
