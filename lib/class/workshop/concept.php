<?

namespace Workshop
{
	class Concept extends \System\Model\Perm
	{
		protected static $attrs = array(
			'name' => array('varchar'),
			'desc' => array('html'),
			'visible' => array('bool'),
		);


		protected static $access = array(
			"browse" => true,
			"schema" => true,
		);
	}
}
