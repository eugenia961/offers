<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Interfaces\ReaderInterface;
use App\Interfaces\OfferRepositoryInterface;

class LoadReadOffersCommand extends Command {

    protected static $defaultName = 'load_read_offer_command';
    private $readerInterface;
    private $offerRepositoryInterface;

    public function __construct(ReaderInterface $readerInterface, OfferRepositoryInterface $offerRepositoryInterface) {

        $this->readerInterface = $readerInterface;
        $this->offerRepositoryInterface = $offerRepositoryInterface;

        parent::__construct();
    }

    protected function configure() {

        $this->setDescription('Read the offer sources');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $io = new SymfonyStyle($input, $output);

        $response = $this->readerInterface->getUrlDataSrc('GET', 'http://127.0.0.1:8001');

        $offerCollection = $this->readerInterface->read($response);

        $iterator = $offerCollection->getIterator();
        
        foreach ($iterator as $offer) {
           
            $this->offerRepositoryInterface->save($offer);
        }

        $io->success("OK: " . $offerCollection->count());
    }

}
