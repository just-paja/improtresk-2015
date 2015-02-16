<?

$start = new DateTime("2015-03-01 17:00:00+01:00");
$end   = new DateTime("2015-04-20 20:00:00+01:00");
$now   = new DateTime();

$started = $now > $start;
$ended   = $now > $end;


$this->partial('forms/signup', array(
	"start"   => $start,
	"start_f" => $start->format('j.n. \v G:i'),
	"end"     => $end,
	"started" => $started,
	"ended"   => $ended,
	"show"    => $started && !$ended,
));
