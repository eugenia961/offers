<?php

namespace App\ValidObjects;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class DateRangesValidObject {

    private $dateRangesValidObject;

    public function __construct($dateRanges) {

        $this->dateRangesIsValid($dateRanges);

        $this->dateRangesValidObject = [
            'startDate' => new \DateTime($dateRanges['startDate'])
            , 'endDate' => new \DateTime($dateRanges['endDate'])
        ];
    }

    public function value() {
        
        return $this->dateRangesValidObject;
    }

    private function dateRangesIsValid($dateRanges) {

        $startDate = $dateRanges['startDate'];
        $endDate = $dateRanges['endDate'];

        $this->validateDateFormat($startDate);
        $this->validateDateFormat($endDate);

        $dateRangesUnixTime['startDate'] = \strtotime($startDate);
        $dateRangesUnixTime['endDate'] = \strtotime($endDate);

        $this->ragenDatesValid($dateRangesUnixTime);
    }

    private function validateDateFormat($date) {
        if (\DateTime::createFromFormat('Y-m-d H:i:s', $date) === false) {
            throw new BadRequestHttpException(\sprintf("The date %s is not valid.", $date));
        }
    }

    private function ragenDatesValid($dateRangesUnixTime) {

        $startDateUnixTime = $dateRangesUnixTime['startDate'];
        $endDateUnixTime = $dateRangesUnixTime['endDate'];

        if ($endDateUnixTime < $startDateUnixTime) {
            throw new BadRequestHttpException('The end date must be greater than the start date');
        }
    }

}
