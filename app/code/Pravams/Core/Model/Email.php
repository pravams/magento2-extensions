<?php
/**
 * Pravams Core Module
 * 
 * @category Pravams
 * @package Pravams_Core
 * @copyright Copyright (c) 2025 Pravams (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0php Open Software Licnese (OSL 3.0)
*/
namespace Pravams\Core\Model;

class Email extends \Magento\Framework\DataObject{
    /*
     * @var \Magento\Framework\Translate\Inline\StateInterface
     * */
    protected $inlineTranslation;

    /*
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     * */
    protected $_transportBuilder;

    /*
     * @var string
     * */
    protected $temp_id;

    /*
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $$transportBuilder
     * */
    public function __construct(
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    )
    {
        parent::__construct();
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
    }

    public function generateTemplate($emailVariables, $senderInfo, $receiver, $area, $storeId){
        $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
            ->setTemplateOptions(
                [
                    'area' => $area,
                    'store' => $storeId
                ]
            )->setTemplateVars($emailVariables)
            ->setFrom($senderInfo)
            ->addTo($receiver['email'],$emailVariables['receiverName']);

        return $this;
    }

    public function sendEmail($tempId, $emailVariables, $senderInfo, $receiver, $area, $storeId){
        $this->temp_id = $tempId;        
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailVariables, $senderInfo, $receiver, $area, $storeId);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        //var_dump($transport->getMessage()->getBodyHtml()->getContent());exit;
        $this->inlineTranslation->resume();
    }
}
