<?php


namespace Rishi\Emi\Model\ResourceModel;

class Calculator extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('rishi_emi_calculator', 'calculator_id');
    }
}
