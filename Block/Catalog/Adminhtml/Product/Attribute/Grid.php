<?php
namespace Magepow\ProductAttributesMassAction\Block\Catalog\Adminhtml\Product\Attribute;

class Grid extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Grid
{
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_code');
        $this->setMassactionIdFilter('attribute_code');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('attribute_codes');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl(
                    'product_attributes_mass_action/product_attribute/delete'
                ),
                'confirm' => __('Are you sure?')
            ]
        );
    }
}