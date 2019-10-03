<?php


namespace Rishi\Emi\Controller\Adminhtml\Calculator;

class Edit extends \Rishi\Emi\Controller\Adminhtml\Calculator
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('calculator_id');
        $model = $this->_objectManager->create(\Rishi\Emi\Model\Calculator::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This EMI Calculator no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('rishi_emi_calculator', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit EMI Calculator') : __('New EMI Calculator'),
            $id ? __('Edit EMI Calculator') : __('New EMI Calculator')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('EMI Calculators'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit %1 EMI Calculator ', $model->getBank_name()) : __('New Calculator'));
        return $resultPage;
    }
}
