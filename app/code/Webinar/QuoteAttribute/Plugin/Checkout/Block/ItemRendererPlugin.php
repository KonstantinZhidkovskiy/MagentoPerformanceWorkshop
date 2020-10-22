<?php
declare(strict_types=1);

namespace Webinar\QuoteAttribute\Plugin\Checkout\Block;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Block\Cart\Item\Renderer as ItemRenderer;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Webinar\QuoteAttribute\Model\Product\Attribute\QuoteAttribute;

class ItemRendererPlugin
{
    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ItemRendererPlugin constructor.
     *
     * @param Config                     $eavConfig
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Config $eavConfig,
        ProductRepositoryInterface $productRepository
    ) {
        $this->eavConfig = $eavConfig;
        $this->productRepository = $productRepository;
    }

    /**
     * @param ItemRenderer $renderer
     * @param              $options
     * @return mixed
     */
    public function afterGetOptionList(
        ItemRenderer $renderer,
        $options
    ) {
        try {
            $attribute = $this->eavConfig->getAttribute(
                ProductAttributeInterface::ENTITY_TYPE_CODE,
                QuoteAttribute::CODE
            );

            if (!$attribute->getId()) {
                return $options;
            }

            $item = $renderer->getItem();

            try {
                $product = $this->productRepository->getById(
                    $item->getProductId(),
                    false,
                    $item->getQuote()->getStoreId()
                );
            } catch (NoSuchEntityException $exception) {
                return $options;
            }

            $value = $product->getData(QuoteAttribute::CODE) ?: 'Empty value';

            $options[] = [
                'label'       => $attribute->getDefaultFrontendLabel(),
                'value'       => $value,
                'print_value' => $value,
                'option_id'   => null,
                'option_type' => 'text',
                'custom_view' => false,
            ];
            //phpcs:ignore
        } catch (LocalizedException $e) {}

        return $options;
    }
}
