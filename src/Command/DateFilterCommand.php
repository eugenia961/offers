<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use App\Interfaces\OfferRepositoryInterface;
use App\ValidObjects\DateRangesValidObject;
use App\Interfaces\OfferPrintInterface;


class DateFilterCommand extends Command {

    protected static $defaultName = 'date_filter';
    private $offerRepositoryInterface;
    private $offerPrintInterface;

    public function __construct(OfferRepositoryInterface $offerRepositoryInterface, OfferPrintInterface $offerPrintInterface) {


        $this->offerRepositoryInterface = $offerRepositoryInterface;
        $this->offerPrintInterface = $offerPrintInterface;

        parent::__construct();
    }

    protected function configure() {
        $this
                ->setDescription('Find offers by dates and prints the offers in the console')
                ->addArgument('start_date', InputArgument::REQUIRED, 'Start date: yyyy-mm-dd hh:mm:ss')
                ->addArgument('end_date', InputArgument::REQUIRED, 'End date: yyyy-mm-dd hh:mm:ss')
                ->setHelp("This command allows you to find offers by date and prints the offers in the console");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $startDate = $input->getArgument('start_date');
        $endDate = $input->getArgument('end_date');

        $header = "Find offers by dates";

        $header_line = $this->offerPrintInterface->printHeader($header);
        $output->writeln([$header_line, $header, $header_line, '',]);
    

        if ($startDate && $endDate) {

            $dateRanges['startDate'] = $startDate;
            $dateRanges['endDate'] = $endDate;

            $dateRangesValidObject = new DateRangesValidObject($dateRanges);
            $dateRangeObject = $dateRangesValidObject->value();

            $offers = $this->offerRepositoryInterface->findByDates($dateRangeObject);
            $errorMessages = sprintf('Offers with start date [%s] and end date [%s] not found', $dateRanges['startDate'], $dateRanges['endDate']);

            $table = new Table($output);
            $this->offerPrintInterface->printOffer($offers, $table, $errorMessages);
        }
    }

}
