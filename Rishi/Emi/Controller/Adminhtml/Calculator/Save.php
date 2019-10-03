<?php


namespace Rishi\Emi\Controller\Adminhtml\Calculator;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $emis = $this->getRequest()->getParam('emi_options');

        echo "<pre>";
        if(is_array($emis)){
            foreach ($emis as $key=>$emi){
                $emi_tenure[$key] = $emi['emi_tenure'];
                $interest_rate[$key] = $emi['interest_rate'];
            }
            $emi_tenure = implode(',', $emi_tenure);
            $interest_rate = implode(',', $interest_rate);

            $data['emi_tenure'] = $emi_tenure;
            $data['interest_rate'] = $interest_rate;
        }

    //    print_r($data);
    //    echo "<br/><br/><br/>";

        if ($data) {
            $id = $this->getRequest()->getParam('calculator_id');
        
            $model = $this->_objectManager->create(\Rishi\Emi\Model\Calculator::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This EMI Calculator no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            // print_r($model->getData());
            // echo implode(",",$arr);
            // echo "<br/><br/><br/>";
            // print_r($data1);
            // return ;
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the EMI Calculator.'));
                $this->dataPersistor->clear('rishi_emi_calculator');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['calculator_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the EMI Calculator.'));
            }
        
            $this->dataPersistor->set('rishi_emi_calculator', $data);
            return $resultRedirect->setPath('*/*/edit', ['calculator_id' => $this->getRequest()->getParam('calculator_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
