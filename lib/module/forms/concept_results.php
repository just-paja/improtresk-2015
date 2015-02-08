<?

$count = get_all('\Workshop\Request')->count();
$concepts = get_all('\Workshop\Concept')->sort_by('name')->fetch();
$requests = get_all('\Workshop\Request')->add_filter(array(
	'attr' => 'other',
	'type' => 'is_null',
	'is_null' => false
))->sort_by('created_at desc')->fetch();


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
	"count"    => $count,
	"concepts" => $concepts,
	"requests" => $requests
));
