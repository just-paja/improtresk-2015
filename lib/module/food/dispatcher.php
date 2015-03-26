<?

namespace Module\Food
{
	class Dispatcher extends \System\Module
	{
		public function run()
		{
			$f = $this->response->form(array(
				"heading" => 'Výběr oběda',
				"desc"    => 'Stačí vyplnit variabilní symbol a dáme ti na výběr z našeho menu.'
			));

			$f->input(array(
				"label"    => 'Variabilní symbol',
				"name"     => 'symvar',
				"required" => true,
				"type"     => 'number',
				"min"      => 0
			));

			$f->submit('Zobrazit');

			$f->out($this);

			if ($f->passed()) {
				$data = $f->get_data();

				$this->flow->redirect($this->response->url('food.pick', array(
					"symvar" => $data['symvar']
				)));
			}
		}
	}
}
