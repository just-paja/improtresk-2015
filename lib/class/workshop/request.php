<?

namespace Workshop
{
	class Request extends \System\Model\Perm
	{
		protected static $attrs = array(
			'name'      => array('varchar'),
			'email'     => array('varchar'),
			'workshops' => array(
				"type" => 'has_many',
				"model" => 'Workshop\Concept',
				"is_bilinear" => true,
				"is_master" => true
			),

			'other' => array('text', "is_null" => true),
		);
	}
}
