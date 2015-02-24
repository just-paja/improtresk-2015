<?

$status = 400;
$message = 'fill-all-fields';
$data = null;

$icons = \Car\Offer::get_attr_options('icon');
$opts = array();

foreach ($icons as $icon) {
	$opts[] = array('value' => $icon, 'name' => $icon);
}

$f = $response->form(array(
	'use_comm' => true,
));

$f->input(array(
	'type' => 'text',
	'name' => 'driver',
	'required' => true
));

$f->input(array(
	'type' => 'text',
	'name' => 'from',
	'required' => true
));

$f->input(array(
	'type' => 'number',
	'name' => 'seats',
	'min'  => 1,
	'required' => true
));

$f->input(array(
	'type' => 'datetime',
	'name' => 'departure',
	'required' => true
));

$f->input(array(
	'type' => 'select',
	'name' => 'icon',
	'required' => true,
	'options' => $opts
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

		$item = new \Car\Offer($attrs);
		$item->visible = true;
		$item->save();

		$item->send_notif($response);
		$data = $item->get_data();
	} else {
		$data = $f->get_errors();
	}
}


$response->mime = 'text/html';
$this->json_response($status, $message, $data);
