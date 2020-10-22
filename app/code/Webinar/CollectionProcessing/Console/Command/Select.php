<?php
declare(strict_types=1);

namespace Webinar\CollectionProcessing\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\File\Csv;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Filesystem\DirectoryList;

class Select extends Command
{
    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * Select constructor.
     * @param ResourceConnection $resource
     * @param Csv $csv
     * @param DirectoryList $directoryList
     */
    public function __construct(
        ResourceConnection $resource,
        Csv $csv,
        DirectoryList $directoryList
    ) {
        $this->resource = $resource;
        $this->csv = $csv;
        $this->directoryList = $directoryList;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName("webinar:collection:select");
        $this->setDescription('Select collection');
        $this->setHelp(
            <<<HELP
Process collection
HELP
        );
        parent::configure();
    }

    /**
     * Expected "do {\n...} while (...);\n"; found "do {\n...} while(...);\n"
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $this->directoryList->getRoot();
        $mem = memory_get_usage();
        $connection = $this->resource->getConnection();
        $select = $connection->select()->from(
            $this->resource->getTableName('catalog_product_entity')
        );
        $offset = 0;
        $this->csv->appendData($dir . '/var/time.csv', [[0,0]], 'w');
        do {
            $select->limit(10000, $offset);
            $time_start = microtime(true);
            $data = $connection->fetchAll($select);
            $time[] = round(microtime(true) - $time_start, 3);
            $offset += 10000;
            $info = [
                [
                    round(microtime(true) - $time_start, 3),
                    round((memory_get_usage() - $mem) / 1024 / 1024, 2)
                ]
            ];
            $this->csv->appendData($dir . '/var/time.csv', $info, 'a');
        } while ($data);
        return Cli::RETURN_SUCCESS;
    }
}
