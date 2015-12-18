
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
