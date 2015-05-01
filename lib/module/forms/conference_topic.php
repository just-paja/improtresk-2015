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
			if (!\Conference\Topic::is_running() || $this->request->get('ulozeno') == 'neasi') {
				return;
			}

			$total = \Conference\Topic::get_all()->where(array('banned' => false))->count();

			if ($total >= \Conference\Topic::LIMIT_USER) {
				return;
			}

			$f = $this->get_form();

			if ($f->submited()) {
				if ($f->passed()) {
					$t = new \Conference\Topic($f->get_data());
					$t->save();

					$this->flow->redirect($this->response->url('conference').'?ulozeno=neasi');
				}
			}

			$f->out($this);
		}
	}
}
