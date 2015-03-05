<?


namespace Module\Car\Offer\Admin
{
	class Requests extends \System\Module
	{
		public function run()
		{
			$offer = $this->req('offer');
			$rqs_new = $offer->requests->where(array('status' => 1))->fetch();

			if (count($rqs_new) > 0) {
				$fn = \System\Form::from_module($this, array(
					'id' => 'new-requests',
					'prefix'  => 'n_',
					'heading' => 'Nové žádosti uživatelů',
					'desc'    => 'Vyber si, koho chceš svézt. Změny budou okamžitě propsány a uživatelům bude poslán informativní e-mail s kontaktem na Tebe. Pokud si nejsi jistý, zavolej a nebo napiš.',
				));

				foreach ($rqs_new as $item) {
					$fn->input(array(
						'type'     => 'select',
						'name'     => 'status_'.$item->id,
						'label'    => $item->name,
						'desc'     => 'Telefon: '.$item->phone.', E-mail: '.$item->email,
						'required' => true,
						'options'  => array(
							array('name' => 'Potvrdit', 'value' => 2),
							array('name' => 'Zamítnout', 'value' => 4),
						)
					));
				}

				$fn->submit('Uložit');

				if ($fn->passed()) {
					$data = $fn->get_data();

					foreach ($rqs_new as $rq) {
						$name = 'status_'.$rq->id;
						$stat = $rq->status;

						if (isset($data[$name])) {
							$stat = $data[$name];
						}

						$rq->status = $stat;
						$rq->save();
					}
				} else {
					$fn->out($this);
				}
			}

			$rqs_cur = $offer->requests->add_filter(array(
				'attr'  => 'status',
				'type'  => 'exact',
				'exact' => \Car\Request::STATUS_APPROVED
			))->fetch();
			$rqs_old = $offer->requests->add_filter(array(
				'attr'  => 'status',
				'type'  => 'exact',
				'exact' => array(3,4)
			))->fetch();


			if (count($rqs_cur) > 1) {
				$fc = \System\Form::from_module($this);
				$fc->prefix  = 'c_';
				$fc->heading = 'Potvrzené žádosti uživatelů';

				foreach ($rqs_cur as $item) {
					$fc->input(array(
						'type'     => 'select',
						'name'     => 'status_'.$item->id,
						'label'    => $item->name,
						'required' => true,
						'options'  => array(
							array('name' => 'Zrušit', 'value' => 3),
						)
					));
				}

				$fc->submit('Uložit');
				$fc->out($this);
			}

			$this->partial('pages/carshare-requests', array(
				"items" => $rqs_old
			));
		}
	}
}

