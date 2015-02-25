<?

$status = 400;
$message = 'fill-all-fields';
$data = null;

$f = $response->form(array(
	'use_comm' => true,
));

$f->input(array(
	'type' => 'int',
	'name' => 'car',
	'required' => true
));

$f->input(array(
	'type' => 'text',
	'name' => 'name',
	'required' => true
));

$f->input(array(
	'type' => 'text',
	'name' => 'phone',
	'required' => true
));

$f->input(array(
	'type' => 'email',
	'name' => 'email',
	'required' => true
));

$f->input(array(
	'type' => 'textarea',
	'name' => 'desc',
	'required' => false
));


if ($f->submited()) {
	if ($f->passed()) {
		$attrs = $f->get_data();
		$status = 200;
		$message = 'saved';

		$item = new \Car\Request($attrs);
		$item->save();

		$item->send_notif($response);
		$data = $item->get_data();
	} else {
		$data = $f->get_errors();
	}
}


$response->mime = 'text/html';
$this->json_response($status, $message, $data);
