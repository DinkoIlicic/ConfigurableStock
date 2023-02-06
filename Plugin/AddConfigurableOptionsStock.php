<?php

declare(strict_types=1);

namespace Dinko\ConfigurableStock\Plugin;

use Laminas\Json\Json;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable;

class AddConfigurableOptionsStock
{
    /**
     * AddConfigurableOptionsStock constructor.
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        private StockRegistryInterface $stockRegistry
    ) {
    }

    /**
     * Set stock simple stock quantities to the json config
     *
     * @param Configurable $subject
     * @param mixed $result
     * @return string
     */
    public function afterGetJsonConfig(
        Configurable $subject,
        mixed $result
    ) {
        $jsonResult = Json::decode($result, Json::TYPE_ARRAY);
        $jsonResult['stockQuantities'] = [];

        foreach ($subject->getAllowProducts() as $simpleProduct) {
            $id = (int)$simpleProduct->getId();
            $jsonResult['stockQuantities'][$simpleProduct->getId()] =
                (int)$this->stockRegistry->getStockItem($id)->getQty();
        }

        return Json::encode($jsonResult);
    }
}
