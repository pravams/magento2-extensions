<?php 
namespace Pravams\Reservation\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class PreDispatch implements ObserverInterface{

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     * 
    */
    protected $messageManager;

    /***
     * @var \Magento\Framework\Session\SessionManagerInterface
    */
    protected $_session;
    
    /**
     * @var \Magento\Framework\UrlInterface
    */
    protected $_urlManager;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
    */
    protected $redirect;
    
    /**
     * @var Magento\Catalog\Model\ResourceModel\Product\Collection
    */
    protected $productCollection;

    /**
     * @var \Magento\Framework\Message\ManagerInterface $feedFactory
     * @var \Magento\Framework\Session\SessionManagerInterface $_session
     * @var \Magento\Framework\UrlInterface $_urlManager
     * @var \Magento\Framework\App\Response\RedirectInterface $redirect
     * @var Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
    */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Session\SessionManagerInterface $_session,
        \Magento\Framework\UrlInterface $_urlManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
    ){
        $this->messageManager = $messageManager;
        $this->_session = $_session;
        $this->_urlManager = $_urlManager;
        $this->redirect = $redirect;
        $this->productCollection = $productCollection;
    }



    public function execute(Observer $observer){
        $request = $observer->getEvent()->getRequest();
        if($request->getFullActionName() == "checkout_cart_configure"){
            $productId = $request->getParams()['product_id'];
            $configId = $request->getParams()['id'];
            if($productId){
                $products = $this->productCollection;
                $products->addFieldToFilter('entity_id', $productId);
                $product = $products->getFirstItem();
                if($product->getTypeId() == \Pravams\Reservation\Model\Product\Type\Reservation::TYPE_ID){
                    $this->messageManager->addErrorMessage(__('Sorry, a reservation product cannot be edited.'));

                    $controller = $observer->getControllerAction();
                    $url = $this->_urlManager->getUrl('checkout/cart/index');
                    
                    $controller->getResponse()->setRedirect($url);

                    //return $this;
                }else{
                    // original configure page
                    
                }
            }            
        }
    }
}

