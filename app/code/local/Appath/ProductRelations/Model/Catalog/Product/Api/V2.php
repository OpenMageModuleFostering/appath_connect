<?php
/**
 * Product API V2
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

        $product = Mage::getModel('catalog/product')
            ->load($productId);

        $productType = $product->getTypeId();

        if ($productType == 'configurable') {
            $childIds = Mage::getModel('catalog/product_type_configurable')
                ->getChildrenIds($product->getId());

            $tmpArr = array();
            foreach ($childIds[0] as $childId) {
                $tmpArr[] = $childId;
            }
            $result['child_ids'] = implode(",",$tmpArr);
        } elseif ($productType == 'simple') {
            $parentIds = Mage::getModel('catalog/product_type_configurable')
                ->getParentIdsByChild($product->getId());

            $tmpArr = array();
            foreach ($parentIds as $parentId) {
                $tmpArr[] = $parentId;
            }
            $result['parent_ids'] = implode(",",$tmpArr);
        }




        return $result;
    }
}