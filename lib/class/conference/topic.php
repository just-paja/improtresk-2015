<?

namespace Conference
{
	class Topic extends \System\Model\Perm
	{
		const LIMIT_USER = 10;

		static protected $attrs = array(
			"name"   => array("type" => 'varchar'),
			"topic"  => array("type" => 'varchar'),
			"banned" => array("type" => 'bool'),
		);


		static public function is_running()
		{
			$start = new \DateTime("2015-03-15 21:00:00+01:00");
			$end   = new \DateTime("2015-05-07 20:00:00+01:00");
			$now   = new \DateTime();

			$started = $now > $start;
			$ended   = $now > $end;

			return $started && !$ended;
		}
	}
}
