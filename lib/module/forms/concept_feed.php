<?

$status = 400;
$message = 'fill-all-fields';
$data = null;

$opts = get_all('\Workshop\Concept')->fetch();

$opts[666] = 'other';

$f = $response->form(array(
	'use_comm' => true,
));

$f->input(array(
	'type' => 'text',
	'name' => 'name',
	'required' => true
));

$f->input(array(
	'type' => 'email',
	'name' => 'email',
	'required' => true
));

$f->input(array(
	'type' => 'textare',
	'name' => 'other',
	'required' => false
));

$f->input(array(
	'type'      => 'checkbox',
	'name'      => 'workshops',
	'multiple'  => true,
	'required'  => true,
	'options'   => $opts,
));

if ($f->submited()) {
	if ($f->passed()) {
		$p = $f->get_data();
		$up = array();

		foreach ($p['workshops'] as $key=>$val) {
			if ($val != 666) {
				$up[] = $val;
			}
		}

		$p['workshops'] = $up;

		$item = new Workshop\Request($p);
		$item->save();

		$status = 200;
		$message = 'voted';
		$data = $item->to_object();
	}
}

$this->json_response($status, $message, $data);
