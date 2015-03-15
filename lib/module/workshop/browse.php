<?

namespace Module\Workshop
{
	class Browse extends \System\Module
	{
		public function run()
		{
			$items = \Workshop::get_all()->fetch();

			$this->partial('pages/workshops', array(
				"items" => $items
			));
		}
	}
}
