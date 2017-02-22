<?php
/**
 * Copyright © 2015 Sundial. All rights reserved.
 */
namespace Sundial\CommunityCommerce\Model\ResourceModel;

/**
 * Charity resource
 */
class Charityquote extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('communitycommerce_quote_charity', 'id');
    }

  
}
