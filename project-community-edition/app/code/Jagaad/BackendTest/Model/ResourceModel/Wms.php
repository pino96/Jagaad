<?php


namespace Jagaad\BackendTest\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Wms extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('jagaad_wms_history', 'entity_id');
    }
}
