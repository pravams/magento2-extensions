<?php 
/**
 * Pravams Ticket Module
 * 
 * @category Pravams
 * @package Pravams_Ticket
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/
namespace Pravams\Ticket\Controller\Adminhtml\Reply;

use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Post extends \Magento\Backend\App\Action{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    protected $resultPageFactory;

    /**
     * @var LoggerInterface $logger
    */
    private $logger;

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList $directory
    */
    private $directory;

    /**
     * @var \Pravams\Ticket\Model\TicketFactory $ticket
    */
    protected $ticket;

    /**
     * @var \Pravams\Ticket\Model\ReplyFactory $ticketReply
    */
    protected $ticketReply;

    /**
     * @var \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
    */
    protected $replyColl;

    /**
     * @var \Magento\Backend\Model\Auth\Session $authSession
    */
    protected $authSession;

    /**
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
    */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        LoggerInterface $logger,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Pravams\Ticket\Model\TicketFactory $ticket,
        \Pravams\Ticket\Model\ReplyFactory $ticketReply,
        \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl,
        \Magento\Backend\Model\Auth\Session $authSession
    ){
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->logger = $logger;
        $this->directory = $directory;
        $this->ticket = $ticket;
        $this->ticketReply = $ticketReply;
        $this->replyColl = $replyColl;
        $this->authSession = $authSession;
    }

    /**
     * Post ticket
     * 
     * @return Redirect
    */
    public function execute(){
        if(!$this->getRequest()->isPost()){
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $params = $this->getRequest()->getParams();
        $ticketId = $params['ticket_id'];
        $sendType = $params['send'];

        if($sendType == "back"){
            return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/index');
        }
        
        $extensionUser = $this->authSession->getUser();        
        $adminId=$extensionUser->getId();
        $adminName=$extensionUser->getUsername();

        // check the length of subject and details
        if(strlen($params['details'])> 3000){
            $this->messageManager->addErrorMessage(__('Please enter the reply less than 3000 characters'));
            //$this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
        }

        // check for too many ticket replies
        $replyColl = $this->replyColl;
        $replyColl->addFieldToFilter('ticket_id', $ticketId);
        $replyColl->addFieldToFilter('reply_type', \Pravams\Ticket\Model\Reply::TYPE_ADMIN);
        if(count($replyColl) != 0){
            $nowSub = $replyColl->getLastItem()->getCreatedAt();
            $nowSubTime = time() - strtotime($nowSub);
            $diff = $nowSubTime/(60*60);
            $diff = floor($diff);
            if($diff <= 1){
                $this->messageManager->addErrorMessage(__('Please wait for 1 hour before submitting successive replies'));
                //$this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
                return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
            }
        }
        

        try{
            if($this->validateParams()){                
                
                
                $directory = $this->directory;
                $parentId = null;
                
                $ticket = $this->ticket->create();
                $targetFile =  $ticket->uploadFile($directory);
                                                                
                $ticketVal = $ticket->load($ticketId);

                $ticketReply = $this->ticketReply->create();                
                $ticketReply->setTicketId($ticketId);
                $ticketReply->setParentId($parentId);
                $ticketReply->setCustomerName($ticketVal->getCustomerName());
                $ticketReply->setCustomerEmail($ticketVal->getCustomerEmail());
                $ticketReply->setCustomerId($ticketVal->getCustomerId());
                $ticketReply->setSubject($ticketVal->getSubject());
                $ticketReply->setDetails($params['details']);                
                $ticketReply->setFilePath($targetFile);
                $ticketReply->setStatus($ticketVal->getStatus());
                $ticketReply->setAdminId($adminId);
                $ticketReply->setAdminName($adminName);
                $ticketReply->setReplyType(\Pravams\Ticket\Model\Reply::TYPE_ADMIN);
                $ticketReply->save();

                // assigning the ticket to the admin replying this ticket
                $ticketVal->setAssignedAdminId($adminId);
                $ticketVal->setAssignedAdminName($adminName);
                
                $customerName = $ticketVal->getCustomerName();
                $customerEmail = $ticketVal->getCustomerEmail();                    

                if($sendType == "sendandclose"){
                    $ticketVal->setStatus(\Pravams\Ticket\Model\Ticket::CLOSED_STATUS);
                    $this->messageManager->addSuccessMessage(
                        __('Thanks, this ticket is now closed.')
                    );
                    $ticketVal->save();

                    //send email
                    $ticketVal->sendAdminReplyEmail($ticketId, $customerEmail, $customerName);

                    return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
                }else{
                    $ticketVal->setStatus(\Pravams\Ticket\Model\Ticket::ASSIGNED_STATUS);
                }                
                $ticketVal->save();

                //send email
                $ticketVal->sendAdminReplyEmail($ticketId, $customerEmail, $customerName);
                $this->messageManager->addSuccessMessage(
                    __('Thanks for posting reply to the ticket.')
                );
                //$this->dataPersistor->clear('ticket_reply_create');
            }
        }catch(LocalizedException $e){
            $this->messageManager->addErrorMessage($e->getMessage());
            //$this->dataPersistor->set('ticket_reply_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
        }catch(\Exception $e){
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(__('An error occurred while processing your request'));
            //$this->dataPersistor->set('ticket_reply_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
        }
        return $this->resultRedirectFactory->create()->setPath('pravams_ticket/index/view',array('ticket_id'=>$ticketId));
    }

    /**
     * Method to validate params
     * 
     * @return array
     * @throws \Excpetion
    */
    private function validateParams(){
        $request = $this->getRequest();
        $params = $request->getParams(); 
        $sendType = $params['send'];        

        if(trim($request->getParam('details', '')) === ''){
            if($sendType == "sendandclose"){
                throw new LocalizedException(__('Please enter comments in the reply section, before closing this ticket.'));
            }else{
                throw new LocalizedException(__('Enter your reply to the issue and try again.'));
            }
        }
        
        return $request->getParams();
    }
}

