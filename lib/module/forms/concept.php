<?

$end = new DateTime("2015-02-13 20:00:00+01:00");
$now = new DateTime();

$this->partial('forms/concepts', array(
	"show_form" => $now <= $end
));
