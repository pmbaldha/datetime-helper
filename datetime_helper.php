
if (! function_exists('date_difference')) {
    /**
     * Return the difference between two dates.
     *
     * @todo Consider updating this to use date_diff() and/or DateInterval.
     *
     * @param mixed  $start    The start date as a unix timestamp or in a format
     * which can be used within strtotime().
     * @param mixed  $end      The ending date as a unix timestamp or in a
     * format which can be used within strtotime().
     * @param string $interval A string with the interval to use. Valid values
     * are 'week', 'day', 'hour', or 'minute'.
     * @param bool   $reformat If TRUE, will reformat the time using strtotime().
     *
     * @return int A number representing the difference between the two dates in
     * the interval desired.
     */
    function date_difference($start = null, $end = null, $interval = 'day', $reformat = false)
    {
        if (is_null($start)) {
            return false;
        }
        if (is_null($end)) {
            $end = date('Y-m-d H:i:s');
        }
        $times = array(
            'week'   => 604800,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
        );
        if ($reformat === true) {
            $start = strtotime($start);
            $end   = strtotime($end);
        }
        $diff = $end - $start;
        return round($diff / $times[$interval]);
    }
}
if (! function_exists('relative_time')) {
    /**
     * Return a string representing how long ago a given UNIX timestamp was,
     * e.g. "moments ago", "2 weeks ago", etc.
     *
     * @todo Consider updating this to use date_diff() and/or DateInterval.
     * @todo Internationalization.
     *
     * @param int $timestamp A UNIX timestamp.
     *
     * @return string A human-readable amount of time 'ago'.
     */
    function relative_time($timestamp)
    {
        if ($timestamp != '' && ! is_int($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        if (! is_int($timestamp)) {
            return "never";
        }
        $difference = time() - $timestamp;
        $periods = array('moment', 'min', 'hour', 'day', 'week', 'month', 'year', 'decade');
        $lengths = array('60', '60', '24', '7', '4.35', '12', '10', '10');
        if ($difference >= 0) {
            // This was in the past
            $ending = "ago";
        } else {
            // This is in the future
            $difference = -$difference;
            $ending = "to go";
        }
        for ($j = 0; $difference >= $lengths[$j]; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= "s";
        }
        if ($difference < 60 && $j == 0) {
            return "{$periods[$j]} {$ending}";
        }
        return "{$difference} {$periods[$j]} {$ending}";
    }
}

if (! function_exists('date_format')) {
    /**
     * Convert unix time to a human readable time in the user's timezone or in a
     * given timezone.
     *
     * For supported timezones visit - http://php.net/manual/timezones.php
     * For accepted formats visit - http://php.net/manual/function.date.php
     *
     * @example echo date_format();
     * @example echo user_time($timestamp, 'EET', 'l jS \of F Y h:i:s A');
     *
     * @param int    $timestamp A UNIX timestamp. If none is given, current time
     * will be used.
     * @param string $timezone  The destination timezone for the conversion. If
     * none is given, the current user's configured timezone will be used.
     * @param string $format    The format string to apply to the converted
     * timestamp.
     *
     * @return string A string containing the timestamp in the requested format.
     */
    function date_format($timestamp = null, $timezone = null, $format = 'r')
    {
        if (empty($timestamp)) {
            $dtime = new DateTime(null, new DateTimeZone($timezone));
            return $dtime->format($format);
        }
        $dtime = new DateTime();
        if (is_int($timestamp)) {
            $dtime->setTimestamp($timestamp);
        } elseif ($timestamp != 'now') {
            $dtime->modify($timestamp);
        }
        return $dtime->setTimezone(new DateTimeZone($timezone))->format($format);
    }
}
if (! function_exists('time_stamp_from_str')) 
 {
    /**
    * Returns a UNIX timestamp, given either a UNIX timestamp or a valid strtotime() date string.
    * @param string $date_str Datetime string
    * @return string Parsed timestamp
    */
   function time_stamp_from_str($date_str) 
   {
       if (empty($date_str)) {
	       return false;
       }
       if (is_integer($date_str) || is_numeric($date_str)) {
	       $date = intval($date_str);
       } else {
	       $date = strtotime($date_str);
       }

       if ($date === -1) {
	       return false;
       }
       return $date;
   }
}
