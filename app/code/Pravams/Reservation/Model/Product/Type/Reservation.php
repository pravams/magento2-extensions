<?php
/**
 * Pravams Reservation Module
 * 
 * @category Pravams
 * @package Pravams_Reservation
 * @copyright Copyright (c) 2025 Pravams. (http://www.pravams.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/

namespace Pravams\Reservation\Model\Product\Type;

class Reservation extends \Magento\Catalog\Model\Product\Type\AbstractType {

   const TYPE_ID = 'reservation';

   /**
     * Delete data specific for this product type
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return void
     */
   public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product){    

   } 

   public function isVirtual($product){
        return true;
   }

}

