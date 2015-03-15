<?

namespace Workshop
{
	class Check extends \System\Model\Perm
	{
		protected static $attrs = array(
			'currency' => array("type" => 'varchar', "default" => 'CZK'),
			'symvar' => array("type" => 'int', "is_unsigned" => true),
			'amount' => array("type" => 'float'),

			'signup' => array(
				"type" => 'belongs_to',
				"model" => 'Workshop\SignUp'
			),

			'payments' => array(
				"type" => 'has_many',
				"model" => 'Workshop\Payment'
			)
		);


		protected static $access = array(
			"browse" => true,
			"schema" => true,
		);


		protected static function create_symvar($id)
		{
			return intval(date('ymdHi')) + $id;
		}


		public function save()
		{
			parent::save();

			if (!$this->symvar) {
				$this->symvar = self::create_symvar($this->id);
				$this->save();
			}
		}
	}
}
