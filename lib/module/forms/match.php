<?

namespace Module\Forms
{
	class Match extends \System\Module
	{
		public function run()
		{
			$check = \Workshop\Check::get_first(array(
				'symvar'  => $this->symvar,
				'is_paid' => true
			))->fetch();

			if (!$check) {
				throw new \System\Error\NotFound();
			}

			$signup = $check->signup;

			if (!$signup) {
				throw new \System\Error\NotFound();
			}

			$answer = \Survey\TeamAnswer::get_first(array(
				"id_signup" => $signup->id
			))->fetch();

			if (!$answer) {
				return $this->run_form();
			}

			$this->run_thanks();
		}


		public function run_form()
		{
			$this->req('symvar');

			$teams = array(
				 2 => 'Stře.L.I.',
				 3 => 'Dotiky',
				 4 => 'Progresky',
				 5 => 'KIŠ',
				 6 => 'R.A.C.I.',
				 7 => 'Experiment',
				 8 => 'Klika',
				 9 => 'Pro Impro',
				10 => 'K.OP.R.',
				11 => 'V.I.P.',
			);

			$f = $this->response->form(array(
				'heading' => 'Které dva týmy chceš vidět na&nbsp;zápase?',
				'desc'    => 'V pátek v Milevsku proběhne zápas v divadelní improvizaci. Účastníci Improtřesku 2015 mají možnost vybrat si, které dva týmy změří svoje síly na této jedinečné akci.<br><br>Dej si pozor: Jakmile odpověď odešleš, nejde to změnit.',
				'id'      => 'form-teams',
				'default' => array()
			));

			$f->input(array(
				'label'     => 'Vyber dva týmy',
				'type'      => 'checkbox',
				'name'      => 'teams',
				'multiple'  => true,
				'required'  => true,
				'maxlength' => 2,
				'minlength' => 2,
				'options'   => $teams,
				'value'     => []
			));

			$f->submit('Odeslat');

			if ($f->submited()) {
			}

			$f->out($this);

		}


		public function run_thanks()
		{
		}
	}
}
