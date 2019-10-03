<?php


namespace Rishi\Emi\Block\Product;

use \Magento\Catalog\Model\Product;

class Emicalculator extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Product
     */
    protected $_product = null;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;
    protected $resultPageFactory;
    protected $jsonHelper;
    protected $_helper;
    protected $collectionFactory;
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Rishi\Emi\Model\ResourceModel\Calculator\CollectionFactory $collectionFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Rishi\Emi\Helper\Data $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $moduleConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->_collectionFactory = $collectionFactory;
        $this->_helper = $helper;
        $this->scopeConfig = $moduleConfig;
        $this->_registry = $registry;
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function Emicalculator()
    {
        try {
            $resultPage = $this->_collectionFactory->create();
            $emiCollection  = $resultPage->getItems();
            $emiCollection = $resultPage->addFieldToFilter('status', "1")->load();
            $itemCollection = $emiCollection->getData();
            $principal =  $this->getProduct()->getFinalPrice();
            $i = 0;
            if($principal>3000){
                $emitable = '<div class="dropdown">
                <div class="dropdown-content"><div class="emi-tble">
                <span class="emioptionsclose">x</span>
                <h3>EMI Options</h3>';

                foreach($itemCollection as $value){
                    $emi_tenure = explode(',',$value['emi_tenure']);
                    $interest_rate = explode(',',$value['interest_rate']);
                    $emi = array_combine($emi_tenure,$interest_rate);

                    $emitable .= '<button class="accordion">'. $value['bank_name'].'</button>
                    <div class="panel">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                            <td align="center" valign="middle"><h4>Standard EMI Plans</h4></td>
                            </tr>
                            <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td>EMI Plan </td>
                                <td>Interest (PA)</td>
                                <td>Total Cost </td>
                                </tr>';
                                    foreach($emi as $time=>$rate){
                                        $emi1 = $this->emi_calculator($principal, $rate, $time); 
                                        $emitable .= '<tr>
                                            <td>&#8377;'.$emi1.' x '.$time.'m</td>
                                            <td>&#8377;'.(($emi1*$time) - $principal).' ('.$rate.'%)'.'</td>
                                            <td>&#8377;'.$emi1*$time.'</td>
                                            </tr>';
                                    }
                                    $emitable .= '</table></td>
                            </tr>
                            <tr>
                                <td>'. $value['term_conditions'].'</td>
                            </tr>
                        </table
                    </div></div>';    
                    $minemi['price'][$i] = $emi1;
                    $i++;
                }
                $emitable .='</div></div></div>';
                $emitable .="<p><strong>EMI</strong> starts at ₹".$this->getMinEmi($minemi)." Per month. <a href='javascript:void(0)' class='emioptions'>Options</a></p>";
                return  $emitable;
            }
            return false;
            // <a href='javascript:void(0)' class='action_emi'>Options</a>
        
            // return $this->jsonResponse($emitable);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            // $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
    * @return min EMI
    */
   public function getMinEmi($minemi)
   {
       return min($minemi['price']);
   }

    /**
    * @return Product
    */
   public function getProduct()
   {
       if (!$this->_product) {
           $this->_product = $this->_registry->registry('current_product');
       }
       return $this->_product;
   }
    // Function to calculate EMI 
    public function emi_calculator($p, $r, $t) 
    {  
        // one month interest 
        $r = $r / (12 * 100); 

        // tenure period 
        $t = $t/12 * 12;  

        $emi = ($p * $r * pow(1 + $r, $t)) /(pow(1 + $r, $t) - 1); 
        return (round($emi)); 
    } 

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}

