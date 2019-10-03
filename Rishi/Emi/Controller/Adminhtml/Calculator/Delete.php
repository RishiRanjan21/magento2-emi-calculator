<?php


namespace Rishi\Emi\Controller\Adminhtml\Calculator;

class Delete extends \Rishi\Emi\Controller\Adminhtml\Calculator
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('calculator_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Rishi\Emi\Model\Calculator::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the EMI Calculator.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['calculator_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a EMI Calculator to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
