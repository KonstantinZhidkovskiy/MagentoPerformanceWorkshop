<?php
declare(strict_types=1);

namespace Webinar\QuoteAttribute\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillAttributeValue extends Command
{
    /**
     * @var \Webinar\QuoteAttribute\Model\Service\FillAttributeValue
     */
    private $attributeService;

    /**
     * FillAttributeValue constructor.
     *
     * @param \Webinar\QuoteAttribute\Model\Service\FillAttributeValue $attributeService
     * @param string|null                                              $name
     */
    public function __construct(
        \Webinar\QuoteAttribute\Model\Service\FillAttributeValue $attributeService,
        string $name = null
    ) {
        parent::__construct($name);
        $this->attributeService = $attributeService;
    }

    protected function configure()
    {
        $this->setName('webinar:quote-attribute:fill-values')
            ->setDescription('Fills products with random values.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->attributeService->execute();
        $output->writeln('<info>Done.</info>');
    }
}
