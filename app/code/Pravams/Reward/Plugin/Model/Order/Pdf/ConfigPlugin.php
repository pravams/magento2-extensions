<?php
namespace Pravams\Reward\Plugin\Model\Order\Pdf;

class ConfigPlugin{
    public function afterGetTotals($subject, $output){
        $reward = array(
            'title' => 'Reward Discount',
            'source_field' => 'reward',
            'font_size' => '8',
            'display_zero' => 'true',
            'sort_order' => '600',
            'model' => 'Pravams\Reward\Model\Sales\Order\Pdf\Reward'
        );
        $output['reward'] = $reward;
        
        return $output;
    }
}

