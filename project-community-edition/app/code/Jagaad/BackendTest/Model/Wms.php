<?php


namespace Jagaad\BackendTest\Model;


use Magento\Framework\Model\AbstractModel;

class Wms extends AbstractModel
{

    protected function _construct()
    {
        $this->_init('Jagaad\BackendTest\Model\ResourceModel\Wms');
    }
}
