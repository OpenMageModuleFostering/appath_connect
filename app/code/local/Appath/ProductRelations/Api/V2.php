<?php
/**
 * Order API V2
 */
class Appath_ProductRelations_Model_Catalog_Product_Api_V2 extends Mage_Catalog_Model_Product_Api_V2
{
    /**
     * Retrieve full product information
     *
     * @param string $orderIncrementId
     *
     * @return array
     */
    public function info($productId, $store = null, $attributes = null, $identifierType = null)
    {
        $result = parent::info($productId, $store, $attributes, $identifierType);

        $childIds = Mage::getModel('catalog/product_type_configurable')
            ->getChildrenIds($productId);

        foreach ($childIds as $childId) {
            $result['info']['child_ids'][] = $childId;
        }

        $parentIds = Mage::getModel('catalog/product_type_configurable')
            ->getParentIdsByChild($productId);

        foreach ($parentIds as $parentId) {
            $result['info']['parent_ids'][] = $parentId;
        }
        return $result;
    }
}