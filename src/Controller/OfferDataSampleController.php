<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OfferDataSampleController extends AbstractController {

    /**
     * @Route("/", name="offer_data_sample")
     */
    public function index() {

        $offerts = [
            ['name' => 'offer 1',
                'quantity' => 0,
                'offer_date' => date('Y-m-d H:i:s'),
                'price' => 10.00,
                'vendor' => [
                    'name' => 'Vendor 1'
                ]
            ],
            ['name' => 'offer 2',
                'quantity' => 10,
                'offer_date' => date("Y-m-d H:i:s", strtotime('2019-08-20 15:00:00')),
                'price' => (float) 0.00,
                'vendor' => [
                    'name' => 'Vendor 2'
                ]
            ],
            ['name' => 'offer 3',
                'quantity' => 5,
                'offer_date' => date("Y-m-d H:i:s", strtotime('2019-05-20 00:00:00')),
                'price' => (float) 0.50,
                'vendor' => [
                    'id' => 1,
                    'name' => 'Vendor 1'
                ]
            ],
            ['name' => 'offer 4',
                'quantity' => 30,
                'offer_date' => date('Y-m-d H:i:s'),
                'price' => (float) 20.50,
                'vendor' => [
                    'name' => 'Vendor 3'
                ]
            ],
        ];


        return $this->json($offerts)->setEncodingOptions(\JSON_NUMERIC_CHECK);
    }

}
