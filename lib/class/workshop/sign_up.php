<?

namespace Workshop
{
	class SignUp extends \System\Model\Perm
	{
		const PRICE_DISCOUNT = 1200;
		const PRICE_FULL     = 1400;
		const PRICE_LUNCH    = 180;

		const DEADLINE_DISCOUNT = '2015-04-01';


		protected static $prices_cancel = array(
			array(
				"after" => '2015-01-01',
				"price" => .2
			),

			array(
				"after" => '2015-04-08',
				"price" => .8
			),

			array(
				"after" => '2015-04-23',
				"price" => .8
			),
		);


		protected static $attrs = array(
			'name_first' => array("type" => 'varchar'),
			'name_last'  => array("type" => 'varchar'),
			'team'       => array("type" => 'varchar'),
			'email'      => array("type" => 'email'),
			'phone'      => array("type" => 'varchar'),
			'birthday'   => array("type" => 'varchar'),
			'lunch'      => array("type" => 'bool'),

			'check'      => array(
				"type" => 'has_one',
				"model" => 'Workshop\Check'
			),

			'workshops'  => array(
				"bound_to" => 'signups',
				"type" => 'has_many',
				"model" => 'Workshop',
				"is_bilinear" => true,
				"is_master" => true
			),
		);


		protected static $access = array(
			"browse" => true,
			"schema" => true,
			"create" => true,
		);


		public function save()
		{
			parent::save();

			if (!$this->check) {
				$this->create_check();
			}
		}


		public function get_price()
		{
			$deadline = new \DateTime(self::DEADLINE_DISCOUNT);
			$price    = self::PRICE_FULL;

			if ($this->created_at < $deadline) {
				$price = self::PRICE_DISCOUNT;
			}

			if ($this->lunch) {
				$price += self::PRICE_LUNCH;
			}

			return $price;
		}


		protected function create_check()
		{
			$check = new \Workshop\Check(array(
				'amount' => $this->get_price(),
				'signup' => $this
			));

			$check->save();
		}


		public function mail_confirm(\System\Http\Response $res)
		{
			$ren = \System\Template\Renderer\Txt::from_response($res);
			$ren->reset_layout();
			$ren->partial('mail/signup/confirm', array(
				"item" => $this,
				"check" => $this->check,
				"workshops" => $this->workshops->sort_by('id_workshop_signup_has_workshop')->fetch()
			));

			$mail = new \Helper\Offcom\Mail(array(
				'rcpt'     => array($this->email),
				'subject'  => 'Improtřesk 2015 - Potvrzení přihlášky',
				'reply_to' => \System\Settings::get('offcom', 'default', 'reply_to'),
				'message'  => $ren->render_content()
			));

			$mail->send();

			$this->sent_notif = true;
			$this->save();
		}
	}
}
