<?php


/**
 * Class NationalLotteryEvent
 * Detects next lottery event
 */
class NationalLotteryEvent {


    private $eventOn = array(
        array('day' => 'Wednesday', 'time' => '20:00'),
        array('day' => 'Saturday',  'time' => '20:00'),
    );

    private $dateTime = null;

    private $next = null;

    /**
     * NationalLotteryEvent constructor.
     * @param DateTime $dateTime
     */
    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        $this->next = $dateTime;

    }

    /**
     * Function detects the closest event and saves it into the $next variable
     */
    private function findClosest(){

        $dateTime = $this->getDateTime();

        $pickedTimestamp = $dateTime->getTimestamp();

        $timestamps = array();

        foreach($this->eventOn AS $k => $v) {

            $strtt = strtotime( $v['day'] . ' ' . $v['time'], $pickedTimestamp);
            $dt = new DateTime();
            $dt->setTimestamp($strtt);
            $ts = $dt->getTimestamp();

            $timestamps[] = $ts;

        }

        asort($timestamps);

        foreach($timestamps AS $timestamp) {

            if($timestamp >= $pickedTimestamp) {

                $match = new DateTime();
                $match->setTimestamp($timestamp);
                $this->setNext($match);
                break;

            }

        }

    }


    /**
     * @return string
     */
    public function nextEventOn(){

        $this->findClosest();

        $next = $this->getNext();
        $dateTime = $this->getDateTime();

        $diff = $dateTime->diff($next);

        $difference = $diff->days . (($diff->days == 1) ? ' day ' : ' days, ') . $diff->h . ' hours and ' . $diff->i . ' minutes';

        return ''
            . 'Based on picked date: ' . $dateTime->format('l') . ', ' . $dateTime->format('d.m.Y. H:i:s') . ', '
            . 'next Lottery Draw starts in ' . $difference . '; ' . $next->format('l') . ', ' . $next->format('d.m.Y.') . ' at ' . $next->format('H:i');

    }


    /**
     * @return DateTime|null
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime|null $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return DateTime|null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param DateTime|null $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

}

date_default_timezone_set('Europe/London');


/* Initialize the object and set DateTime to now */
$lottery = new NationalLotteryEvent(new DateTime());
echo $lottery->nextEventOn() . "\r\n <br />";

/* Specify new DateTime by using the setter */
$lottery->setDateTime(new DateTime('04.10.2017. 15:28'));
echo $lottery->nextEventOn() . "\r\n <br />";

/* Instantiate new object with custom dateTime */
$custom = new NationalLotteryEvent(new DateTime('06.10.2017.'));
echo $custom->nextEventOn() . "\r\n <br />";



?>