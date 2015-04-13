<?

namespace Survey
{
	class TeamAnswer extends \System\Model\Perm
	{
		static protected $attrs = array(
			"response" => array("type" => 'int_set'),
			"signup" => array(
				"type"  => 'belongs_to',
				"model" => 'Workshop\SignUp',
			),
		);
	}
}
