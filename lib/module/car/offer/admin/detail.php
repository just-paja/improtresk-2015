<?

$this->req('ident');

$offer = \Car\Offer::get_first()
	->where(array(
		'ident'   => $ident,
		'visible' => true
	))
	->fetch();

if ($offer) {
	$cfg = $rq->fconfig;

	$cfg['ui']['data'] = array(
		array(
			'model' => 'Car.Offer',
			'items' => array(
				$offer->to_object_with_perms($rq->user)
			)
		)
	);

	$rq->fconfig = $cfg;
	$res->subtitle = 'úpravy nabídky na sdílení auta';

	$this->partial('pages/carshare-detail', array(
		"item"     => $offer,
		"free"     => $offer->seats - $offer->requests->where(array('status' => 2))->count(),
		"form"     => false,
		"requests" => $offer->requests->where(array('status' => array(1,2)))->fetch(),
	));

} else throw new \System\Error\NotFound();
