<?php

namespace Dmatthew\AttributeDescription\Block\Adminhtml\Attribute\Edit\Options;

/**
 * Attribute add/edit form options tab
 */
class Descriptions extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var string
     */
    protected $_template = 'Dmatthew_AttributeDescription::catalog/product/attribute/descriptions.phtml';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_registry = $registry;
    }

    /**
     * Retrieve stores collection with default store.
     *
     * @return \Magento\Store\Model\ResourceModel\Store\Collection
     */
    public function getStores()
    {
        if (!$this->hasStores()) {
            $this->setData('stores', $this->_storeManager->getStores());
        }
        return $this->_getData('stores');
    }

    /**
     * Retrieve frontend descriptions of attribute for each store.
     *
     * @return array
     */
    public function getDescriptionValues()
    {
        $values = [];
        $storeDescriptions = $this->getAttributeObject()->getStoreDescriptions();
        foreach ($this->getStores() as $store) {
            if ($store->getId() != 0) {
                $values[$store->getId()] = isset($storeDescriptions[$store->getId()]) ? $storeDescriptions[$store->getId()] : '';
            }
        }
        return $values;
    }

    /**
     * Retrieve attribute object from registry.
     *
     * @return \Magento\Eav\Model\Entity\Attribute\AbstractAttribute
     * @codeCoverageIgnore
     */
    private function getAttributeObject()
    {
        return $this->_registry->registry('entity_attribute');
    }
}
