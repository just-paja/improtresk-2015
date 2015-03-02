<?


namespace Module\Car\Offer\Admin
{
	class Requests extends \System\Module
	{
		public function run()
		{
			$offer = $this->req('offer');

			$rqs_new = $offer->requests->where(array('status' => 1))->fetch();
			$rqs_cur = $offer->requests->where(array('status' => 2))->fetch();
			$rqs_old = $offer->requests->add_filter(array(
				'attr'  => 'status',
				'type'  => 'exact',
				'exact' => array(3,4)
			))->fetch();

			if (count($rqs_new) > 0) {
				$fn = \System\Form::from_module($this);
				$fn->prefix  = 'n_';
				$fn->heading = 'Nové žádosti uživatelů';

				foreach ($rqs_new as $item) {
					$fn->input(array(
						'type'     => 'select',
						'name'     => 'status_'.$item->id,
						'label'    => $item->name,
						'required' => true,
						'options'  => array(
							array('name' => 'Potvrdit', 'value' => 2),
							array('name' => 'Zamítnout', 'value' => 4),
						)
					));
				}

				$fn->submit('Uložit');
				$fn->out($this);
			}

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

