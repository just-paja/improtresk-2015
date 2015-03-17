<?

namespace Module\Stats
{
	class Signups extends \System\Module
	{
		public function run()
		{
			$stats = array(
				"total"   => \Workshop\SignUp::get_all()->count(),
				"unpaid"    => \Workshop\SignUp::get_all()->where(array('paid' => false))->count(),
				"paid"    => \Workshop\SignUp::get_all()->where(array('paid' => true))->count(),
				"waiting" => \Workshop\SignUp::get_all()->where(array('paid' => true, 'solved' => false))->count(),
				"solved"  => \Workshop\SignUp::get_all()->where(array('solved' => true))->count(),
			);

			$ws = \Workshop::get_all()->fetch();

			foreach ($ws as $w) {
				$w->sig_total = $w->signups->count();
				$w->ass_total = $w->assignees->count();
			}

			$this->partial('stats/signups', array(
				"stats" => $stats,
				"workshops" => $ws,
			));
		}
	}
}
