<?php

namespace Miniature;

use DateTime;

class Holiday {

    private $month = \NULL;
    private $year = \NULL;
    private $dateFormat = \NULL;
    private $tempDate = \NULL;
    private $numOfYears = \NULL;
    private $easter = \NULL;
    public $holidays = []; // array of holidays:

    public function __construct($date = null, $numOfYrs = 1) {
        $this->dateFormat = new DateTime($date, new \DateTimeZone("America/Detroit"));
        $this->year = $this->dateFormat->format("Y");
        $this->month = $this->dateFormat->format("F");
        $this->numOfYears = $numOfYrs;
    }

    public function setConstructor($date = \NULL, $numOfYears = 1) {
        self::__construct($date, $numOfYears);
    }

    private function convertToDisplayDate($tempDate = \NULL) {
        $this->dateFormat = new DateTime($tempDate, new \DateTimeZone("America/Detroit"));
        return $this->tempDate = $this->dateFormat->format("F j, Y");
    }

    public function holidays() {

            $this->holidays[$this->year . "-01-01"] = "New Year's Day";
            if ($this->year > 1969 && $this->year < 2038) {
                $this->easter = new DateTime('@' . easter_date($this->year), new \DateTimeZone("America/Detroit"));
                $this->holidays[$this->easter->format("Y-m-d")] = "Easter Sunday";
            }
            $this->holidays[\date("Y-m-d", \strtotime("Last Monday of May " . $this->year))] = "Memorial Day";
            $this->holidays[$this->year . "-07-04"] = "4th of July";
            $this->holidays[\date("Y-m-d", \strtotime("First Monday of September " . $this->year))] = "Labor Day";
            $this->holidays[\date("Y-m-d", \strtotime("Fourth Thursday of November" . $this->year))] = "Thanksgiving Day";
            $this->holidays[$this->year . '-12-25'] = "Christmas Day";

        return $this->holidays;
    }

}
