<?

namespace Car
{
	class Request extends \System\Model\Perm
	{
		const STATUS_NEW      = 1;
		const STATUS_APPROVED = 2;
		const STATUS_CANCELED = 3;
		const STATUS_DENIED   = 4;


		protected static $attrs = array(
			"addr" => array("type" => 'varchar'),
			"car"  => array(
				"type" => 'belongs_to',
				"model" => 'Car\Offer'
			),

			"name"  => array("type" => 'varchar'),
			"desc"  => array("type" => 'text'),
			"phone" => array("type" => 'varchar'),
			"email" => array("type" => 'email'),

			"seats" => array(
				"type" => 'int',
				"is_unsigned" => true,
				"min" => 1,
			),

			"status"=> array(
				"type" => 'int',
				"is_unsigned" => true,
				"options" => array(
					self::STATUS_NEW      => 'car-status-new',
					self::STATUS_APPROVED => 'car-status-approved',
					self::STATUS_CANCELED => 'car-status-canceled',
					self::STATUS_DENIED   => 'car-status-denied',
				),
			),
		);


		protected static $access = array(
			'schema' => true
		);
	}
}
