<?

namespace Car\Offer\Admin
{
	class Edit extends \System\Module
	{
		public function run()
		{
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

				$this->partial('pages/carshare-admin', array(
					"item"     => $offer,
					"requests" => $offer->requests->fetch()
				));
			} else throw new \System\Error\NotFound();
		}
	}
}
