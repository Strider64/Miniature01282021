<?php

namespace Miniature;

use DateTime;
use DateTimeZone;
use Exception;
use JetBrains\PhpStorm\Pure;
use Miniature\Database as DB;
use PDO;

class CalendarDynamic {

    protected $username;
    protected $query;
    protected $stmt;
    protected $prev;
    public $current;
    protected $next;
    public $selectedMonth;
    public $n;
    public $index = 0;
    public $result;

    public array $dayName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    public array $output = []; // The HTML Calender:
    protected $holiday;
    protected $now;
    protected $monthlyChange;
    protected $pageName = "index";
    protected $generate;

    protected static function pdo(): PDO
    {
        $db = DB::getInstance();
        return $db->getConnection();
    }

    /* Constructor to create the output */

    public function __construct($date = "Now") {
        try {
            $this->selectedMonth = new DateTime($date, new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
            error_log("Caught $e");
        }
        try {
            $this->current = new DateTime($date, new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
            error_log("Caught $e");
        }
        $this->current->modify("first day of this month");
        $this->n = $this->current->format("n"); // Current Month as a number (1-12):
    }

    #[Pure] public function checkIsAValidDate($myDateString): bool
    {
        return (bool) strtotime($myDateString);
    }

    public function phpDate(): void
    {
        $setDate = filter_input(INPUT_GET, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $valid = $this->checkIsAValidDate($setDate);
        if (isset($setDate) && strlen($setDate) === 10 && $valid) {
            $this->__construct($setDate);
        }
    }

    protected function isItToday(): void
    {
        /*
         * If selected month (user) equals today's date then highlight the day, if
         * not then treat it as a normal day to be displayed.
         */

        if ($this->now->format("F j, Y") === $this->current->format("F j, Y")) {
            $this->output[$this->index]['class'] = 'day day--today';
            $this->output[$this->index]['date'] = $this->now->format("j");
        } else {
            $this->todaysSquares(); // Check to See if it is a Holiday:
        }
    }

    protected function todaysSquares(): void
    {

        $result = $this->checkForEntry($this->current->format("Y-m-d"));

        if ($result) {
            $bold = "day-entry";
            $this->output[$this->index]['entry'] = '?location=' . $this->selectedMonth->format('Y-m-d') . '&blog=' . $this->current->format('Y-m-d');
        } else {
            $bold = null;
        }

        /*
         * Determine if just a regular day or if it's a holiday.
         */
        if (array_key_exists($this->current->format("Y-m-d"), $this->holiday)) {
            $this->output[$this->index]['class'] = 'day day--holiday' . $bold;
            $this->output[$this->index]['date'] = $this->current->format("j");
        } else { // Just a Normal day
            $this->output[$this->index]['class'] = 'day day' . $bold;
            $this->output[$this->index]['date'] = $this->current->format("j");
        }
    }

    protected function checkForEntry($calDate, $page = 'index.php'): bool
    {

        $this->username = isset($_SESSION['user']) ? $_SESSION['user']->username : NULL;

        $this->query = 'SELECT 1 FROM cms WHERE page=:page AND DATE_FORMAT(date_added, "%Y-%m-%d")=:date_added';

        $this->stmt = static::pdo()->prepare($this->query);

        $this->stmt->execute([':page' => $page, ':date_added' => $calDate]);

        $this->result = $this->stmt->fetch();

        /* If result is true there is data in day, otherwise no data */
        if ($this->result) {
            return TRUE;
        }

        return FALSE;
    }

    protected function drawDays(): void
    {

        try {
            $this->now = new DateTime("Now", new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
            error_log("Caught $e");
        }
        $x = 1;
        while ($x <= 7) {
            /*
             * Determine if selected month (user) equals current month to be
             * displayed. If it is proceed with check dates, if not the fade
             * the box (using HTML classes) ,so that the user will know that
             * it is not the month currently being displayed.
             */
            if ($this->selectedMonth->format('n') === $this->current->format('n')) {
                $this->isItToday(); // Check for Today & Holidays:
            } else {
                /*
                 * Fade out previous and next month's dates
                 * (note prev-date class is both previous & next month dates)
                 * (Me Bad)
                 */
                $this->output[$this->index]['class'] = 'day day--disabled';
                $this->output[$this->index]['date'] = $this->current->format("j");
            }

            $this->current->modify("+1 day");
            ++$x;
            ++$this->index;
        }
    }

    protected function controls(): void
    {
        /* Grab Current Month to be Displayed */
        try {
            $this->monthlyChange = new DateTime($this->current->format("F j, Y"));
        } catch (Exception $e) {
            error_log("Caught $e");
        }
        /* Figure Out Previous Month for Previous Button */
        $this->monthlyChange->modify("-1 month");
        /* Assign Previous Month to a Variable */
        $this->prev = $this->monthlyChange->format("Y-m-d");
        /* Figure Out Next Month for Next Button */
        $this->monthlyChange->modify("+2 month");
        /* Assign Next Month to a Variable */
        $this->next = $this->monthlyChange->format("Y-m-d");

        /* Create Previous / Next Buttons for the Calendar */
        $this->output[$this->index]['previous'] = $this->pageName . '?location=' . $this->prev;
        /*
         * Month Being Displayed Variable
         */
        $this->output[$this->index]['month'] = $this->current->format('F Y');
        $this->output[$this->index]['next'] = $this->pageName . '?location=' . $this->next;
        ++$this->index;
    }

    /*
     * Create has to go to Mert Cukuren
     * as he is the one that has a tutorial
     * out thee on the web that I can't find now.
     * However, the codepen of it is at
     * https://codepen.io/knyttneve/pen/QVqyNg
     */
    protected function HTMLDisplay(): string
    {
        $this->generate = '<div class="calendar-container">' . "\n";
        $this->generate .= '<div class="calendar-header">' . "\n";
        $this->generate .= '<a data-pos="prev" class="prev-left" href="' . $this->output[0]['previous'] . '">prev</a>' . "\n";
        $this->generate .= '<h1 class="output-month">' . $this->output[0]['month'] . '</h1>' . "\n";
        $this->generate .= '<a data-pos="next" class="next-right" href="' . $this->output[0]['next'] . '">next</a>' . "\n";
        $this->generate .= '</div>' . "\n"; // End of calendar-header:


        /*
         * Start of Calendar Grid
         */
        $this->generate .= '<div id="block" class="calendar">' . "\n";

            for ($i=0; $i <= count($this->dayName) - 1; $i++) {
                $this->generate .= '<span class="day-name">' . $this->dayName[$i] . '</span>' . "\n";
            }

            for ($j=1; $j <= count($this->output) - 1; $j++ ) {
                $this->generate .= '<div class="' . $this->output[$j]['class'] . '">' . $this->output[$j]['date'] . '</div>' . "\n";
            }

        $this->generate .= '</div>' . "\n"; // End of calendar container:
        $this->generate .= '</div>' . "\n"; // End of calendar-container:
        return $this->generate;
    }

    protected function display(): string
    {
        /* Grab Holiday from Holiday Class (if there is one) */
        $holidayCheck = new Holiday($this->current->format("F j, Y"), 1);
        /* Assign Holiday to a Variable/Argument */
        $this->holiday = $holidayCheck->holidays();



        $this->controls(); // Create Buttons for Previous/Next Calendars:




        /* Generate last Sunday of previous Month */
        $this->current->modify("last sun of previous month");

        /*
         * Output 6 rows (42 days) guarantees an even calendar that will
         * display nicely.
         */
        $num = 1;
        while ($num <= 6) {
            $this->drawDays(); // Grab the Current Row of Dates:
            ++$num;
        }
        //echo "<pre>" . print_r($this->output, 1) . "</pre>";
        return $this->HTMLDisplay();
    }

    public function generateCalendar(string $pageName = "index"): string
    {
        $this->pageName = $pageName; // The Page the Calendar is On:
        return $this->display();
    }

}
