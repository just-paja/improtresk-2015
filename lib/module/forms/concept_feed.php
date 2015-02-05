<?

$status = 400;
$message = 'fill-all-fields';
$data = null;

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
	'type'      => 'checkbox',
	'name'      => 'workshops',
	'multiple'  => true,
	'required'  => true,
	'options'   => get_all('\Workshop\Concept')->fetch(),
));

if ($f->submited) {
	if ($f->passed()) {
		$p = $f->get_data();

		$item = new Workshop\Request($p);
		$item->save();

		$item->workshops = $p['workshops'];
		$item->save();

		$status = 200;
		$message = 'logged-in';
		$data = $item->to_object();
	}
}

$this->json_response($status, $message, $data);
