<?

$this->req('id');

$offer = \Car\Offer::get_first()
	->where(array(
		'id_car_offer' => $id,
		'visible' => true
	))
	->fetch();

if ($offer) {
	$res->subtitle = $offer->driver.' vás zve na cestu na Improtřesk 2015';

	$this->partial('pages/carshare-detail', array(
		"item"     => $offer,
		"free"     => $offer->seats - $offer->requests->where(array('status' => 2))->count(),
		"requests" => $offer->requests->where(array('status' => array(1,2)))->fetch()
	));
} else throw new \System\Error\NotFound();