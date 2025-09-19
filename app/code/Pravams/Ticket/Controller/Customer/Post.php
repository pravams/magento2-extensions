<?php
namespace Pravams\Ticket\Controller\Customer;

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
     * @var \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
    */
    protected $ticketColl;

    /**
     * @var \Magento\Customer\Model\Session $session
    */
    protected $session;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $looger
     * @param \Magento\Framework\Filesystem\DirectoryList $directory
     * @param \Pravams\Ticket\Model\TicketFactory $ticket
     * @param \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl
     * @param \Magento\Customer\Model\Session $session
    */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Pravams\Ticket\Model\TicketFactory $ticket,
        \Pravams\Ticket\Model\ResourceModel\Ticket\Collection $ticketColl,
        \Magento\Customer\Model\Session $session
    ){
        parent::__construct($context);
        $this->context = $context;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;
        $this->directory = $directory;
        $this->ticket = $ticket;
        $this->ticketColl = $ticketColl;
        $this->session = $session;
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
        try{
            if($this->validateParams()){
                $params = $this->getRequest()->getParams();                
                
                // check the length of subject and details
                if(strlen($params['subject'])> 200){
                    $this->messageManager->addErrorMessage(__('Please enter the subject less than 200 characters'));
                    $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
                    return $this->resultRedirectFactory->create()->setPath('ticket/customer/create');
                }
                if(strlen($params['details'])> 3000){
                    $this->messageManager->addErrorMessage(__('Please enter the details less than 3000 characters'));
                    $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
                    return $this->resultRedirectFactory->create()->setPath('ticket/customer/create');
                }


                $session = $this->session;;
                $customerId = $session->getCustomerId();
                // check for too many tickets
                $ticketColl = $this->ticketColl;
                $ticketColl->addFieldToFilter('customer_id', $customerId);
                if(count($ticketColl) != 0){
                    $nowSub = $ticketColl->getLastItem()->getCreatedAt();
                    $nowSubTime = time() - strtotime($nowSub);
                    $diff = $nowSubTime/(60*60);
                    $diff = floor($diff);
                    if($diff <= 8){
                        $this->messageManager->addErrorMessage(__('Please wait for 8 hours before creating successive tickets'));
                        $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
                        return $this->resultRedirectFactory->create()->setPath('ticket/customer/create');
                    }
                }
                

                $customerName=$session->getCustomerData()->getFirstName()." ".$session->getCustomerData()->getLastName();
                $customerEmail = $session->getCustomer()->getData('email');
                
                $directory = $this->directory;
                $ticket = $this->ticket->create();
                $targetFile =  $ticket->uploadFile($directory);                                
                
                $ticket->setCustomerName($customerName);
                $ticket->setCustomerEmail($customerEmail);
                $ticket->setCustomerId($customerId);
                $ticket->setSubject($params['subject']);
                $ticket->setDetails($params['details']);
                $ticket->setPriorityLevel($params['priority']);
                $ticket->setFilePath($targetFile);
                $ticket->setStatus(\Pravams\Ticket\Model\Ticket::OPEN_STATUS);
                $ticket->save();

                $ticketId = $ticket->getId();
                $ticket->sendAdminEmail($ticketId, $customerEmail, $customerName);
                $this->messageManager->addSuccessMessage(
                    __('Thanks for creating this ticket, you should get a reply in less than 24 hours.')
                );
                $this->dataPersistor->clear('ticket_create');
            }
        }catch(LocalizedException $e){
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('ticket/customer/create');
        }catch(\Exception $e){
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(__('An error occurred while processing your request'));
            $this->dataPersistor->set('ticket_create', $this->getRequest()->getParams());
            return $this->resultRedirectFactory->create()->setPath('ticket/customer/create');
        }
        return $this->resultRedirectFactory->create()->setPath('ticket/customer/index');
    }

    /**
     * Method to validate params
     * 
     * @return array
     * @throws \Excpetion
    */
    private function validateParams(){
        $request = $this->getRequest();
        
        if(trim($request->getParam('subject', '')) === ''){
            throw new LocalizedException(__('Enter a subject and try again.'));
        }
        if(trim($request->getParam('details', '')) === ''){
            throw new LocalizedException(__('Enter details of the issue and try again.'));
        }
        if(trim($request->getParam('priority', '')) === ''){
            throw new LocalizedException(__('Select a priority and try again.'));
        }

        return $request->getParams();
    }
    
}