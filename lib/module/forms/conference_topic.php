<?

namespace Module\Forms
{
	class ConferenceTopic extends \System\Module
	{
		public function get_form()
		{
			$opts = array();
			$f = $this->response->form();
			$ws = \Workshop::get_all();

			foreach ($ws as $w) {
				$opts[$w->id] = $w->name;
			}

			$f->input(array(
				'name'     => 'name',
				'type'     => 'text',
				'label'    => 'Jméno',
				'required' => true,
				'maxlength' => 255
			));

			$f->input(array(
				'name'      => 'topic',
				'type'      => 'textarea',
				'label'     => 'Téma',
				'required'  => true,
				'maxlength' => 255
			));

			$f->submit('Vložit');

			return $f;
		}


		public function run()
		{
			if (\Conference\Topic::is_running()) {
				$f = $this->get_form();

				if ($f->submited()) {
					if ($f->passed()) {
						$d = $f->get_data();

					}
				}

				$f->out($this);
			}
		}
	}
}
