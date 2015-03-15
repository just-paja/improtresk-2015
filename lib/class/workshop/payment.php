<?

namespace Workshop
{
	class Payment extends \System\Model\Perm
	{
		const FORMAT_DATE = 'Y-m-dO';

		const FEED_KEY_LIST  = 'transactionList';
		const FEED_KEY_MOVES = 'transaction';

		protected static $pairs = array(
			array(
				"col"  => '0',
				"attr" => 'received'
			),

			array(
				"col"  => '1',
				"attr" => 'amount'
			),

			array(
				"col"  => '2',
				"attr" => 'from'
			),

			array(
				"col"  => '3',
				"attr" => 'bank'
			),

			array(
				"col"  => '4',
				"attr" => 'symcon'
			),

			array(
				"col"  => '5',
				"attr" => 'symvar'
			),

			array(
				"col"  => '6',
				"attr" => 'symspc'
			),

			array(
				"col"  => '14',
				"attr" => 'currency'
			),

			array(
				"col"  => '22',
				"attr" => 'ident'
			),

		);

		protected static $attrs = array(
			'ident'    => array("type" => 'varchar', "is_unique" => true),
			'symvar'   => array("type" => 'varchar', "is_null" => true),
			'symcon'   => array("type" => 'varchar', "is_null" => true),
			'symspc'   => array("type" => 'varchar', "is_null" => true),
			'amount'   => array("type" => 'float'),
			'from'     => array("type" => 'varchar', "is_null" => true),
			'bank'     => array("type" => 'varchar', "is_null" => true),
			'message'  => array("type" => 'varchar', "is_null" => true),
			'currency' => array("type" => 'varchar', "is_null" => true),
			'received' => array("type" => 'datetime', "is_null" => true),

			'check' => array(
				"type" => 'belongs_to',
				"model" => 'Workshop\Check',
				"is_null" => true,
			)
		);


		protected static $access = array(
			"browse" => true,
			"schema" => true,
		);


		public static function pair_with_feed(array $feed)
		{
			if (!array_key_exists(self::FEED_KEY_LIST, $feed) || !is_array($feed[self::FEED_KEY_LIST])) {
				throw new \System\Error\Argument('Invalid feed format', self::FEED_KEY_LIST);
			}

			$list = $feed[self::FEED_KEY_LIST];

			if (!array_key_exists(self::FEED_KEY_MOVES, $lsit) || !is_array($lsit[self::FEED_KEY_MOVES])) {
				throw new \System\Error\Argument('Invalid feed format', self::FEED_KEY_MOVES);
			}

			foreach ($list as $item) {
				self::pair_with_transaction($item);
			}
		}


		public static function pair_with_transaction(array $item)
		{
			$trans = self::transaction_to_assoc($item);

			if (isset($trans['ident']) || isset($trans['symvar'])) {
				// Ignored - not an interesting payment
				return;
			}

			$match = self::get_first(array(
				'ident' => $trans['ident'],
				'symvar' => $trans['symvar']
			))->fetch();

			if ($match) {
				// Ignored - transaction already paired
				return;
			}

			$check = \Workshop\Check::get_first()->where(array(
				"symvar" => $trans['symvar']
			))->fetch();

			if (!$check) {
				// Ignored - transaction without check
				return;
			}

			$item = new self($trans);
			$item->check = $check;
			$item->save();
		}


		public static function transaction_to_assoc(array $item)
		{
			$assoc = array();

			foreach (self::$pairs as $pair) {
				$name = 'column'.$pair['col'];

				if (array_key_exists($name, $item)) {
					$col = $item[$name];

					if (is_array($col) && array_key_exists($col['value'])) {
						$assoc[$pair['attr']] = $col['value'];
					}
				}
			}

			return $assoc;
		}
	}
}
