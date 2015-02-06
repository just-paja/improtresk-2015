<?

$concepts = get_all('\Workshop\Concept')->sort_by('name')->fetch();

foreach ($concepts as $ws) {
	$ws->total = $ws->requests->count();
}

usort($concepts, function($a, $b) {
	if ($a->total == $b->total) {
		return 0;
	}

	return $a->total > $b->total ? -1:1;
});

$this->partial('concept/results', array(
	"concepts" => $concepts
));
