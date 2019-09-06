<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use App\Interfaces\OfferRepositoryInterface;
use App\Interfaces\OfferPrintInterface;
use App\ValidObjects\OfferPriceValidObject;


class PriceFilterCommand extends Command {

    protected static $defaultName = 'price_filter';
    private $offerRepositoryInterface;
    private $offerPrintInterface;

    public function __construct(OfferRepositoryInterface $offerRepositoryInterface, OfferPrintInterface $offerPrintInterface) {


        $this->offerRepositoryInterface = $offerRepositoryInterface;
        $this->offerPrintInterface = $offerPrintInterface;

        parent::__construct();
    }

    protected function configure() {
        $this
                ->setDescription('Find offers by prices')
                ->addArgument('start_price', InputArgument::REQUIRED, 'Start price')
                ->addArgument('end_price', InputArgument::REQUIRED, 'End price');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $startPrice = $input->getArgument('start_price');
        $endPrice = $input->getArgument('end_price');

        $header = "Find offers by price";
        $header_line = $this->offerPrintInterface->printHeader($header);
        $output->writeln([$header_line, $header, $header_line, '',]);

        if ($startPrice && $endPrice) {

            $priceRanges = [
                'startPrice' => $startPrice,
                'endPrice' => $endPrice
            ];

            $offerPriceValidObject = new OfferPriceValidObject($priceRanges);
            $pricesRangesObject = $offerPriceValidObject->value();

            $offers = $this->offerRepositoryInterface->findByPrices($pricesRangesObject);

            $table = new Table($output);
            $errorMessages = sprintf('Offers with start price [%s] and end price [%s] not found', $pricesRangesObject['startPrice'], $pricesRangesObject['endPrice']);
            
            $this->offerPrintInterface->printOffer($offers, $table, $errorMessages);
        }
    }

}
