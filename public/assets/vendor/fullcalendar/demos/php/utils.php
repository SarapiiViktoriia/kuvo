<?php
date_default_timezone_set('UTC');
class Event {
	const ALL_DAY_REGEX = '/^\d{4}-\d\d-\d\d$/'; 
	public $title;
	public $allDay; 
	public $start; 
	public $end; 
	public $properties = array(); 
	public function __construct($array, $timezone=null) {
		$this->title = $array['title'];
		if (isset($array['allDay'])) {
			$this->allDay = (bool)$array['allDay'];
		}
		else {
			$this->allDay = preg_match(self::ALL_DAY_REGEX, $array['start']) &&
				(!isset($array['end']) || preg_match(self::ALL_DAY_REGEX, $array['end']));
		}
		if ($this->allDay) {
			$timezone = null;
		}
		$this->start = parseDateTime($array['start'], $timezone);
		$this->end = isset($array['end']) ? parseDateTime($array['end'], $timezone) : null;
		foreach ($array as $name => $value) {
			if (!in_array($name, array('title', 'allDay', 'start', 'end'))) {
				$this->properties[$name] = $value;
			}
		}
	}
	public function isWithinDayRange($rangeStart, $rangeEnd) {
		$eventStart = stripTime($this->start);
		$eventEnd = isset($this->end) ? stripTime($this->end) : null;
		if (!$eventEnd) {
			return $eventStart < $rangeEnd && $eventStart >= $rangeStart;
		}
		else {
			return $eventStart < $rangeEnd && $eventEnd > $rangeStart;
		}
	}
	public function toArray() {
		$array = $this->properties;
		$array['title'] = $this->title;
		if ($this->allDay) {
			$format = 'Y-m-d'; 
		}
		else {
			$format = 'c'; 
		}
		$array['start'] = $this->start->format($format);
		if (isset($this->end)) {
			$array['end'] = $this->end->format($format);
		}
		return $array;
	}
}
function parseDateTime($string, $timezone=null) {
	$date = new DateTime(
		$string,
		$timezone ? $timezone : new DateTimeZone('UTC')
	);
	if ($timezone) {
		$date->setTimezone($timezone);
	}
	return $date;
}
function stripTime($datetime) {
	return new DateTime($datetime->format('Y-m-d'));
}
