<?

$this->req('ident');

$offer = \Car\Offer::get_first()
	->where(array(
		'ident' => $ident,
		'visible' => true
	))
	->fetch();

if ($offer) {
	$res->subtitle = $offer->driver.' vás zve na cestu na Improtřesk 2015';

	$this->partial('pages/carshare-detail', array(
		"item"     => $offer,
		"requests" => $offer->requests->fetch()
	));
} else throw new \System\Error\NotFound();
