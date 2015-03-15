<?

namespace
{
	class Workshop extends \System\Model\Perm
	{
		const SEATS_OPENED = 10;

		protected static $attrs = array(
			'name'     => array("type" => 'varchar'),
			'lector'   => array("type" => 'varchar'),
			'desc'     => array("type" => 'html'),
			'opened'   => array("type" => 'int', "default" => self::SEATS_OPENED),
			'signups'  => array(
				"type" => 'has_many',
				"model" => 'Workshop\SignUp',
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
