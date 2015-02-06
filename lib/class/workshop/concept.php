<?

namespace Workshop
{
	class Concept extends \System\Model\Perm
	{
		protected static $attrs = array(
			'name' => array('varchar'),
			'desc' => array('html'),
			'visible' => array('bool'),
			'requests' => array(
				"type" => 'has_many',
				"model" => 'Workshop\Request',
				"is_bilinear" => true,
				"is_master" => false
			),
		);


		protected static $access = array(
			"browse" => true,
			"schema" => true,
		);
	}
}
