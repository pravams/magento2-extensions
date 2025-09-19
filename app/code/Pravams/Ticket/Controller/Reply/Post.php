<?php
namespace Pravams\Ticket\Controller\Reply;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;
use Psr\Log\LoggerInterface;


class Post extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
    */
    private $dataPersistor;

    /**
     * @var Context
    */
    private $context;

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
     * @var \Magento\Customer\Model\Session $session
    */
    protected $session;

    /**
     * @var \Magento\User\Model\ResourceModel\User\Collection $adminUser
    */
    protected $adminUser;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $looger
     * @param \Magento\Framework\Filesystem\DirectoryList $directory
     * @param \Pravams\Ticket\Model\TicketFactory $ticket
     * @param \Pravams\Ticket\Model\ReplyFactory $ticketReply
     * @param \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\User\Model\ResourceModel\User\Collection $adminUser
    */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Pravams\Ticket\Model\TicketFactory $ticket,
        \Pravams\Ticket\Model\ReplyFactory $ticketReply,
        \Pravams\Ticket\Model\ResourceModel\Reply\Collection $replyColl,
        \Magento\Customer\Model\Session $session,
        \Magento\User\Model\ResourceModel\User\Collection $adminUser
    ){
        parent::__construct($context);
        $this->context = $context;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;
        $this->directory = $directory;
        $this->ticket = $ticket;
        $this->ticketReply = $ticketReply;
        $this->replyColl = $replyColl;
        $this->session = $session;
        $this->adminUser = $adminUser;
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

        // check the length of subject and details
        if(strlen($params['details'])> 3000){
            $this->messageManager->addErrorMessage(__('Please enter the reply less than 3000 characters'));
            $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('ticket/customer/view',array('id'=>$ticketId));
        }

        // check for too many ticket replies
        $replyColl = $this->replyColl;
        $replyColl->addFieldToFilter('ticket_id', $ticketId);
        $replyColl->addFieldToFilter('reply_type', \Pravams\Ticket\Model\Reply::TYPE_CUSTOMER);
        if(count($replyColl) != 0){
            $nowSub = $replyColl->getLastItem()->getCreatedAt();
            $nowSubTime = time() - strtotime($nowSub);
            $diff = $nowSubTime/(60*60);
            $diff = floor($diff);
            if($diff <= 1){
                $this->messageManager->addErrorMessage(__('Please wait for 1 hour before submitting successive replies'));
                $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
                return $this->resultRedirectFactory->create()->setPath('ticket/customer/view',array('id'=>$ticketId));
            }
        }
        

        try{
            if($this->validateParams()){                
                
                $session = $this->session;;
                $customerId = $session->getCustomerId();
                $customerName=$session->getCustomerData()->getFirstName()." ".$session->getCustomerData()->getLastName();
                $customerEmail = $session->getCustomer()->getData('email');
                
                $directory = $this->directory;
                $parentId = null;

                $ticket = $this->ticket->create();
                $targetFile =  $ticket->uploadFile($directory);
                                                                
                $ticketVal = $ticket->load($ticketId);

                $ticketReply = $this->ticketReply->create();                
                $ticketReply->setTicketId($ticketId);
                $ticketReply->setParentId($parentId);
                $ticketReply->setCustomerName($customerName);
                $ticketReply->setCustomerEmail($customerEmail);
                $ticketReply->setCustomerId($customerId);
                $ticketReply->setSubject($ticketVal->getSubject());
                $ticketReply->setDetails($params['details']);                
                $ticketReply->setFilePath($targetFile);
                $ticketReply->setStatus($ticketVal->getStatus());
                $ticketReply->setReplyType(\Pravams\Ticket\Model\Reply::TYPE_CUSTOMER);
                $ticketReply->save();

                // get admin email
                $adminId = $ticketVal->getAssignedAdminId();
                $adminEmail = null;
                if($adminId != null){
                    $adminUser = $this->adminUser;
                    $adminUser->addFieldToFilter('user_id', $adminId);
                    $adminUserVal = $adminUser->getFirstItem();
                    $adminEmail = $adminUserVal->getEmail();
                }

                if($sendType == "sendandclose"){
                    $ticketVal->setStatus(\Pravams\Ticket\Model\Ticket::CLOSED_STATUS);
                    $ticketVal->save();                    

                    //send email
                    $ticketVal->sendCustomerReplyEmail($ticketId, $customerEmail, $customerName, $adminEmail);
                    $this->messageManager->addSuccessMessage(
                        __('Thanks, this ticket is now closed.')
                    );
                    return $this->resultRedirectFactory->create()->setPath('ticket/customer/view', array('id'=>$ticketId));
                }             
                
                // send email
                $ticketVal->sendCustomerReplyEmail($ticketId, $customerEmail, $customerName, $adminEmail);
                $this->messageManager->addSuccessMessage(
                    __('Thanks for posting reply to the ticket, you should get an update in less than 24 hours.')
                );
                $this->dataPersistor->clear('ticket_reply_create');
            }
        }catch(LocalizedException $e){
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('ticket_reply_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('ticket/customer/view',array('id'=>$ticketId));
        }catch(\Exception $e){
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(__('An error occurred while processing your request'));
            $this->dataPersistor->set('ticket_reply_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('ticket/customer/view',array('id'=>$ticketId));
        }
        return $this->resultRedirectFactory->create()->setPath('ticket/customer/view', array('id'=>$ticketId));
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