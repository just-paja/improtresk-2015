<?

namespace Module\Conference
{
	class Topics extends \System\Module
	{
		public function run()
		{
			$items = \Conference\Topic::get_all()->where(array('banned' => false))->fetch();

			$this->partial('conference/topics', array(
				"limit"   => \Conference\Topic::LIMIT_USER,
				"running" => \Conference\Topic::is_running(),
				"items"   => $items,
				"total"   => count($items),
			));
		}
	}
}
