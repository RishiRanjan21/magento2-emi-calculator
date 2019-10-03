<?php


namespace Rishi\Emi\Controller\Emi;

 class Calculate extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $_helper;
    protected $collectionFactory;
    protected $_storeManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Rishi\Emi\Model\ResourceModel\Calculator\CollectionFactory $collectionFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Rishi\Emi\Helper\Data $helper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $moduleConfig,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
        $this->_collectionFactory = $collectionFactory;
        $this->_helper = $helper;
        $this->scopeConfig = $moduleConfig;
        $this->_coreRegistry = $registry;
        $this->request = $request;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            // var_dump($this->request->getPostValue());
            //  return $this->request->getParams();
            $resultPage = $this->_collectionFactory->create();
            $emiCollection  = $resultPage->getItems();
            $emiCollection = $resultPage->addFieldToFilter('status', "1")->load();
            $itemCollection = $emiCollection->getData();
            $principal = 129990;
            $i=0;
            foreach($itemCollection as $value){
                $emi_tenure = explode(',',$value['emi_tenure']);
                $interest_rate = explode(',',$value['interest_rate']);
                $emi = array_combine($emi_tenure,$interest_rate);
                // echo "<pre>";
                echo $principal; echo '<br>';
                echo $value['bank_name'];
                // echo $value['term_conditions'];
                // print_r($emi);
                print_r("
                <table>
                <th>EMI Plan</th>
                <th>Interest(pa)</th>
                <th>Total cost</th>");
               
                foreach($emi as $time=>$rate){
                    $emi1 = $this->emi_calculator($principal, $rate, $time); 
                    print_r("<tr>
                        <td>".$emi1.' x '.$time."</td>
                        <td>".(($emi1*$time) - $principal).' ('.$rate.'%)'."</td>
                        <td>".$emi1*$time."</td>
                    </tr>");
                  
                    $minemi['price'][$i] = $emi1;
                    $i++;
                }
                echo "</table>";

                // $last_names = array_column($emi2, 'price');
                // print_r(min($emi2['price']));
            }
            print_r("<p><strong>EMI</strong> starts at ₹".$this->getMinEmi($minemi).". <a href='javascript:void(0)' class='action_emi'>Options</a> </p>");
           
            // return $this->jsonResponse($itemCollection);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            // $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
    * @return Product
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
           $this->_product = $this->_coreRegistry->registry('product');
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


