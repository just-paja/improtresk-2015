<?

$this->req('ident');

$offer = \Car\Offer::get_first()
	->where(array(
		'ident'   => $ident,
		'visible' => true
	))
	->fetch();

if ($offer) {
	$res->subtitle = $offer->driver.' vás zve na cestu na Improtřesk 2015';

	$this->partial('pages/carshare-detail', array(
		"item"     => $offer,
		"free"     => $offer->seats - $offer->requests->where(array('status' => 2))->count(),
		"form"     => true,
		"requests" => $offer->requests->where(array('status' => array(1,2)))->fetch()
	));
} else throw new \System\Error\NotFound();
