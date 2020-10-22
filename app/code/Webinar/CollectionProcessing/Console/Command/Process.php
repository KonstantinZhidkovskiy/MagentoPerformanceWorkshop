<?php
declare(strict_types=1);

namespace Webinar\CollectionProcessing\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Filesystem\DirectoryList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\State;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\File\Csv;
use Magento\Framework\App\ResourceConnection;
use Magento\Catalog\Model\ProductRepository;

class Process extends Command
{
    /**
     * @var State
     */
    private $state;

    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * Process constructor.
     * @param ProductCollectionFactory $productCollectionFactory
     * @param State $state
     * @param ResourceConnection $resource
     * @param Csv $csv
     * @param ProductRepository $productRepository
     * @param DirectoryList $directoryList
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        State $state,
        ResourceConnection $resource,
        Csv $csv,
        ProductRepository $productRepository,
        DirectoryList $directoryList
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->state = $state;
        $this->resource = $resource;
        $this->csv = $csv;
        $this->productRepository = $productRepository;
        $this->directoryList = $directoryList;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName("webinar:collection:process");
        $this->setDescription('Process collection');
        $this->setHelp(
            <<<HELP
Process collection
HELP
        );
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $this->directoryList->getRoot();
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToSelect('name');
        $this->csv->appendData($dir . '/var/time.csv', [[0,0]], 'w');
        $time_start = microtime(true);
        $mem = memory_get_usage();
        $collection->setPageSize(100);
        $collection->setCurPage(1);
        foreach ($collection as $i => $product) {
            $product->setName(
                strtolower($product->getName())
            );
            $data = [
                [
                    round(microtime(true) - $time_start, 3),
                    round((memory_get_usage() - $mem) / 1024 / 1024, 2)
                ]
            ];
            $this->productRepository->save($product);
            $this->csv->appendData($dir . '/var/time.csv', $data, 'a');
        }
        return Cli::RETURN_SUCCESS;
    }
}
