<?php
require dirname(__FILE__) . '/utils.php';
if (!isset($_GET['start']) || !isset($_GET['end'])) {
	die("Please provide a date range.");
}
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);
$timezone = null;
if (isset($_GET['timezone'])) {
	$timezone = new DateTimeZone($_GET['timezone']);
}
$json = file_get_contents(dirname(__FILE__) . '/../json/events.json');
$input_arrays = json_decode($json, true);
$output_arrays = array();
foreach ($input_arrays as $array) {
	$event = new Event($array, $timezone);
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}
echo json_encode($output_arrays);
