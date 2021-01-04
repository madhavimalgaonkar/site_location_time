<?php

namespace Drupal\site_location_time\Service;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Provides a service to return formatted date based on timezone selected.
 */
class SiteTime {
    /*
    * @var \Drupal\Component\Datetime\Time $time
    */
    protected $time;

    /*
    * @var \Drupal\Core\Datetime\DateFormatter $dateFormatter
    */
    protected $dateFormatter;

    /**
     * Constructs a new Time object.
    * @param \Drupal\Core\Datetime\DateFormatter
    */
    public function __construct(Time $time, DateFormatter $dateFormatter) {
        $this->time = $time;
        $this->dateFormatter = $dateFormatter;
    }

    /**
    * @param string $timezone
    * The timezone.
    *
    * @return string
    * Return the formatted date.
    */
    public function getTime ($timezone) {
        $unixdate = $this->time->getRequestTime(); 
        $formattted = $this->dateFormatter->format($unixdate, 'custom', 'jS M Y - h:i A', $timezone);
        return $formattted;
    }
}