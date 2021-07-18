<?php

namespace Jagaad\BackendTest\Block\Adminhtml\Product;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

/**
 * Class SyncWmsButton
 */
class SyncWmsButton extends Generic
{
    /**
     * {@inheritdoc}
     */
    public function getButtonData()
    {
        return [
            'label' => __('Sync with WMS'),
            'class' => 'action-secondary',
            'on_click' => sprintf("location.href = '%s';", $this->getSyncUrl()),
            'sort_order' => 20
        ];
    }

    private function getSyncUrl()
    {
        $id = $this->context->getRequestParam('id', false);
        return $this->getUrl('jagaad_product/product/sync', ['id' => $id]);
    }

    /**
     * Retrieve target for button.
     *
     * @return string
     */
    protected function getSyncTarget()
    {
        $target = 'product_form.product_form';
        return $target;
    }

    /**
     * Retrieve action for button.
     *
     * @return string
     */
    protected function getSyncAction()
    {
        $action = 'sync';
        return $action;
    }
}
