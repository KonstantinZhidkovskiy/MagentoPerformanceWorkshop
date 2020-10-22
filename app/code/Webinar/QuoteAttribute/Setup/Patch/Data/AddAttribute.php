<?php
declare(strict_types=1);

namespace Webinar\QuoteAttribute\Setup\Patch\Data;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class AddAttribute implements DataPatchInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetup;

    /**
     * AddAttribute constructor.
     *
     * @param EavSetup $eavSetup
     */
    public function __construct(
        EavSetup $eavSetup
    ) {
        $this->eavSetup = $eavSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->eavSetup->removeAttribute(ProductAttributeInterface::ENTITY_TYPE_CODE, 'test_quote_attribute');

        $this->eavSetup->addAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            \Webinar\QuoteAttribute\Model\Product\Attribute\QuoteAttribute::CODE,
            [
                'type'             => 'varchar',
                'backend'          => '',
                'frontend'         => '',
                'label'            => 'Test Quote Attribute',
                'input'            => 'text',
                'class'            => '',
                'source'           => '',
                'global'           => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible'          => true,
                'required'         => false,
                'user_defined'     => false,
                'default'          => '',
                'searchable'       => false,
                'filterable'       => false,
                'comparable'       => false,
                'visible_on_front' => true,
                'unique'           => false,
                'apply_to'         => null,

            ]
        );
    }
}
