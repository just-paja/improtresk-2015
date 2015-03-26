<?

namespace Module\Food
{
	class Picker extends \System\Module
	{
		public function run()
		{
			$this->req('symvar');

			$check = \Workshop\Check::get_first(array(
				"symvar" => $this->symvar
			))->fetch();

			if (!$check) {
				throw new \System\Error\NotFound();
			}

			$signup = $check->signup;

			if (!$signup) {
				throw new \System\Error\NotFound();
			}

			$picked = $signup->food->fetch();
			$food = \Food\Item::get_all(array("edible" => true))->fetch();
			$days = array();
			$data = array(
				'soup_2015-05-08' => 666,
				'main_2015-05-08' => 666,
				'soup_2015-05-09' => 666,
				'main_2015-05-09' => 666,
			);

			foreach ($picked as $item) {
				$date = $item->date->format('Y-m-d');
				$type = $item->type == 1 ? 'soup':'main';
				$name = $type.'_'.$date;

				$data[$name] = $item->id;
			}

			foreach ($food as $item) {
				$date = $item->date->format('Y-m-d');
				$type = $item->type == 1 ? 'soup':'main';

				if (!array_key_exists($date, $days)) {
					$days[$date] = array(
						"date" => $item->date,
						"soup" => array(
							array("name" => 'Bez polévky', "value" => 666),
						),
						"main" => array(
							array("name" => 'Překvapte mě', "value" => 666),
						),
					);
				}

				$days[$date][$type][] = $item;
			}

			$f = $this->response->form(array(
				"heading" => 'Vyber si obědy',
				"desc"    => 'Předvol si obědy na Improtřesk 2015',
				"id"      => 'food-picker',
				"default" => $data,
			));

			foreach ($days as $date=>$day) {
				$f->input(array(
					"type"  => 'radio',
					"label" => 'Polévka '.$day['date']->format('j.n.'),
					"name"  => 'soup_'.$date,
					"options" => $day['soup'],
					"required" => true,
				));

				$f->input(array(
					"type"  => 'radio',
					"label" => 'Hlavní chod '.$day['date']->format('j.n.'),
					"name"  => 'main_'.$date,
					"options" => $day['main'],
					"required" => true,
				));
			}

			$f->submit('Uložit');
			$f->out($this);
		}
	}
}
