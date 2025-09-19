<?php 
namespace Pravams\Ticket\Model;

use \Magento\Framework\Model\ResourceModel\AbstractResource;
use \Magento\Framework\Data\Collection\AbstractDb;

class Ticket extends \Magento\Framework\Model\AbstractModel{

    const OPEN_STATUS = "open";
    const ASSIGNED_STATUS = "assigned";
    const CLOSED_STATUS = "closed";

    protected function _construct(){
        parent::_construct();
        $this->_init('Pravams\Ticket\Model\ResourceModel\Ticket');
    }

    /**
     * \Magento\Framework\App\Action\Context $context
     * \Magento\Framework\Registry $registry
     * \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * \Magento\Store\Model\StoreManagerInterface $storeManager
     * \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
     * \Magento\Framework\App\AreaList $areaList
     * \Magento\Framework\Escaper $escaper,
     * \Pravams\Core\Model\Email $pravamEmail
     * array $data = []
    */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\Framework\App\AreaList $areaList,
        \Magento\Framework\Escaper $escaper,
        \Pravams\Core\Model\Email $pravamsEmail,
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,        
        array $data = []
    ){
        $this->storeManager = $storeManager;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->areaList = $areaList;
        $this->escaper = $escaper;
        $this->pravamsEmail = $pravamsEmail;
        parent::__construct($context, $registry, $resource, $resourceCollection,  $data);
    }

    /**
     * upload file for both ticket and reply
    */
    public function uploadFile($directory){
        
        $directoryRootPath = $directory->getRoot();
        
        // create a directory for file upload if it is not there.
        if(!file_exists($directoryRootPath.'/pub/media/pravams_ticket')){
            mkdir($directoryRootPath.'/pub/media/pravams_ticket', 0777, true);
        }

        $targetDir = $directoryRootPath.'/pub/media/pravams_ticket/';
        $targetFileName = time()."-".$_FILES['file_path']['name'];
        $targetFileNameVal = '/media/pravams_ticket/'.$targetFileName;        
        $targetFile = $targetDir.basename($targetFileName);

        $uploadOk = 1;
        $imageType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if(strlen($_FILES['file_path']['name']) == 0){
            return null;
        }
        
        // check if image file is an image
        if(isset($_POST['submit'])){
            if(strlen($_FILES['file_path']['tmp_name']) == 0){
                $uploadOk = 0;
                throw new \Magento\Framework\Exception\LocalizedException(__('There is some problem in file attachment. Please try different format'));                
            }else{
                $check = getimagesize($_FILES['file_path']['tmp_name']);
                if($check != false){
                    $uploadOk = 1;
                }else{
                    $uploadOk = 0;
                    throw new \Magento\Framework\Exception\LocalizedException(__('There is some problem in file attachment.'));
                }
            }
            
        }

        // check file size
        if($_FILES['file_path']['size'] > 500000){
            $uploadOk = 0;
            throw new \Magento\Framework\Exception\LocalizedException(__('File size is too large.'));
        }

        // check allowed image formats
        if($imageType != 'jpg' && $imageType != 'png' && $imageType != 'jpeg' && $imageType != 'gif'){
            $uploadOk = 0;
            throw new \Magento\Framework\Exception\LocalizedException(__('Sorry only JPG, JPEG, PNG and GIF files are allowed.'));
        }

        // check if file is uploaded by any other error
        if($uploadOk = 0){
            throw new \Magento\Framework\Exception\LocalizedException(__('Sorry an error occurred'));
        }else{
            if(move_uploaded_file($_FILES['file_path']['tmp_name'], $targetFile)){

            }else{
                throw new \Magento\Framework\Exception\LocalizedException(__('Sorry an error occurred while uploading the file. Please try again.'));
            }
        }

        return $targetFileNameVal;
    }

    public function getScopeConfig(){
        $scopeConfig = $this->scopeConfigInterface;
        return $scopeConfig;
    }

    public function sendAdminEmail($ticketId, $customerEmail, $customerName){
        $scopeConfig = $this->getScopeConfig();
        $fromName = $scopeConfig->getValue('trans_email/ident_support/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $companyName = $scopeConfig->getValue('general/store_information/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $supportEmail = $scopeConfig->getValue('trans_email/ident_support/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        $messageLine1 = "A new ticket #".$ticketId." has been created by the customer.";
        $fromEmail = $supportEmail;
        $toEmail = $supportEmail;
        $toName = "Dear Sir";
        $receiverName = $fromName;
        $tempId = "new_ticket_email_template";

        $storeManager = $this->storeManager;                
        $areaList = $this->areaList;
        $accountUrl = $storeManager->getStore()->getBaseUrl();                
        $adminPath = $areaList->getFrontName('adminhtml');
        $accountUrl = $accountUrl.$adminPath;

        $this->sendEmail($messageLine1, $fromEmail, $toEmail, $toName, $receiverName, $companyName, $supportEmail, $fromName, $tempId, $ticketId, $accountUrl);
    }

    public function sendCustomerReplyEmail($ticketId, $customerEmail, $customerName, $adminEmail){
        $scopeConfig = $this->getScopeConfig();
        $fromName = $scopeConfig->getValue('trans_email/ident_support/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $companyName = $scopeConfig->getValue('general/store_information/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $supportEmail = $scopeConfig->getValue('trans_email/ident_support/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $supportName = $fromName;

        $messageLine1 = "The ticket #".$ticketId." has been updated by the customer.";
        $fromEmail = $customerEmail;
        if($adminEmail != null){
            $toEmail = $adminEmail;
        }else{
            $toEmail = $supportEmail;
        }        
        $toName = "Dear Sir";
        $receiverName = $supportName;
        $tempId = "reply_ticket_email_template";
        $fromName = $customerName;

        $storeManager = $this->storeManager;     
        $areaList = $this->areaList;           
        $accountUrl = $storeManager->getStore()->getBaseUrl();                
        $adminPath = $areaList->getFrontName('adminhtml');
        $accountUrl = $accountUrl.$adminPath;

        $this->sendEmail($messageLine1, $fromEmail, $toEmail, $toName, $receiverName, $companyName, $supportEmail, $fromName, $tempId, $ticketId, $accountUrl);
    }

    public function sendAdminReplyEmail($ticketId, $customerEmail, $customerName){
        $scopeConfig = $this->getScopeConfig();
        $fromName = $scopeConfig->getValue('trans_email/ident_support/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $companyName = $scopeConfig->getValue('general/store_information/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $supportEmail = $scopeConfig->getValue('trans_email/ident_support/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $supportName = $fromName;

        $messageLine1 = "The ticket #".$ticketId." has been updated by the support team.";
        $fromEmail = $supportEmail;
        $toEmail = $customerEmail;        
        $toName = "Dear ".$customerName;
        $receiverName = $customerName;
        $tempId = "reply_ticket_email_template";
        $fromName = $companyName;

        $storeManager = $this->storeManager;                
        $areaList = $this->areaList;
        $accountUrl = $storeManager->getStore()->getBaseUrl();

        $this->sendEmail($messageLine1, $fromEmail, $toEmail, $toName, $receiverName, $companyName, $supportEmail, $fromName, $tempId, $ticketId, $accountUrl);
    }

    /**
     * Send email notification to the support team or customer
    */
    public function sendEmail($messageLine1, $fromEmail, $toEmail, $toName, $receiverName, $companyName, $supportEmail, $fromName, $tempId, $ticketId, $accountUrl){        
        $escaper = $this->escaper;
                        
        $storeId = 1;
        
        /* Receiver Email **/
        $receiver = [
            'email' => $escaper->escapeHtml($toEmail)
        ];

        /* Sender Detail **/
        $senderInfo = [
            'name' => $escaper->escapeHtml($fromName),
            'email' => $escaper->escapeHtml($fromEmail)
        ];

        $area = \Magento\Framework\App\Area::AREA_FRONTEND;
        
        
        $emailVariables = array();
        $emailVariables['receiverName'] = $receiverName;
        $emailVariables['messageLineOne'] = $messageLine1;
        $emailVariables['accountUrl'] = $accountUrl;
        $emailVariables['toName'] = $toName;
        $emailVariables['fromName'] = $fromName;
        $emailVariables['companyName'] = $companyName;
        $emailVariables['ticketNumber'] = $ticketId;

        $pravamsEmail = $this->pravamsEmail;
        $pravamsEmail->sendEmail(
            $tempId, $emailVariables, $senderInfo, $receiver, $area, $storeId
        );
        
    }
}