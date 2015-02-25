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
				"default" => self::STATUS_NEW,
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


		public function send_notif(\System\Http\Response $res)
		{
			$ren = \System\Template\Renderer\Txt::from_response($res);
			$ren->reset_layout();
			$ren->partial('mail/car/request', array(
				"item"  => $this,
				"offer" => $this->car,
				"admin" => $res->url_full('carshare_admin', array($this->car->ident))
			));

			$mail = new \Helper\Offcom\Mail(array(
				'rcpt'    => array($this->car->email),
				'subject' => 'Improtřesk 2015 - Sdílení auta',
				'message' => $ren->render_content()
			));

			$mail->send();

			$this->sent_notif = true;
			$this->save();
		}
	}
}
