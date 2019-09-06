<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use App\Interfaces\OfferRepositoryInterface;
use App\Interfaces\OfferPrintInterface;

class VendorOffersCountCommand extends Command {

    protected static $defaultName = 'vendor_offers_count';
    private $offerRepositoryInterface;
    private $offerPrintInterface;

    public function __construct(OfferRepositoryInterface $offerRepositoryInterface, OfferPrintInterface $offerPrintInterface) {


        $this->offerRepositoryInterface = $offerRepositoryInterface;
        $this->offerPrintInterface = $offerPrintInterface;

        parent::__construct();
    }

    protected function configure() {
        $this
                ->setDescription('Find offer by vendor_name and prints the offerts in the console')
                ->addArgument('vendor_name', InputArgument::REQUIRED, 'vendor name')
                ->setHelp("This command allows you to find all offerts by vendor_id and prints the offerts in the console");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $vendorName = $input->getArgument('vendor_name');

        $header = "Find offer by vendor_name";
        $header_line = $this->offerPrintInterface->printHeader($header);
        $output->writeln([$header_line, $header, $header_line, '',]);

        if ($vendorName) {

            $offers = $this->offerRepositoryInterface->findByVendorName($vendorName);
            $errorMessages = sprintf('Offer with vendor_id [%s] not found', $vendorName);

            $table = new Table($output);
            $this->offerPrintInterface->printOffer($offers, $table, $errorMessages);
            
            
        }
    }

}
