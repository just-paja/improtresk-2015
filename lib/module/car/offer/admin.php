<?

$this->req('ident');

$offer = \Car\Offer::get_first()
	->where(array(
		'ident'   => $ident,
		'visible' => true
	))
	->fetch();

if ($offer) {
	$res->subtitle = 'úpravy nabídky na sdílení auta';

	$f = \System\Form::from_module($this, array(
		"default" => $offer->get_data()
	));

	$f->input(array(
		'name'     => 'seats',
		'label'    => 'Počet nabídnutých míst',
		'type'     => 'number',
		'step'     => 1,
		'required' => true
	));

	$f->input(array(
		'name'     => 'departure',
		'label'    => 'Čas odjezdu',
		'type'     => 'datetime',
		'required' => true
	));

	$f->input(array(
		'name'     => 'desc',
		'label'    => 'Zpráva pro cestující',
		'type'     => 'textarea',
		'required' => true
	));

	$f->out($this);

	$this->partial('pages/carshare-admin', array(
		"item"     => $offer,
		"requests" => $offer->requests->fetch()
	));
} else throw new \System\Error\NotFound();
