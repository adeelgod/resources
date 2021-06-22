<?php


namespace Meetanshi\FaceBookShop\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;


class Uninstall implements UninstallInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
		
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		
		$eavSetup->removeAttribute(
            Product::ENTITY,
            'enable_fb_product'
		);
		$eavSetup->removeAttribute(
            Product::ENTITY,
            'product_condition'
		);
		$eavSetup->removeAttribute(
            Product::ENTITY,
            'google_product_category'
		);
		$eavSetup->removeAttribute(
            Category::ENTITY,
            'google_product_category'
		);

        $connection = $setup->getConnection();
        $connection->dropTable($connection->getTableName('meetanshi_facebook_attribute'));
        $connection->dropTable($connection->getTableName('meetanshi_facebook_feed_report'));

        $setup->endSetup();
    }
}
