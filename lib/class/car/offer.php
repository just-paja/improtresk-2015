<?

namespace Car
{
	class Offer extends \System\Model\Perm
	{
		protected static $attrs = array(
			"color"     => array("type" => 'varchar'),
			"desc"      => array("type" => 'text', 'is_null' => true),
			"driver"    => array("type" => 'varchar'),
			"from"      => array("type" => 'varchar'),
			"departure" => array("type" => 'datetime'),
			"phone"     => array("type" => 'varchar'),
			"email"     => array("type" => 'email'),
			"ident"     => array("type" => 'varchar', 'is_unique' => true),
			"icon"      => array(
				"type" => 'varchar',
				"default" => 'sedan',
				"options" => array(
					'sedan'        => 'sedan',
					'combi'        => 'combi',
					'hatchback'    => 'hatchback',
					'hatchback-3d' => 'hatchback-3d',
					'coupe'        => 'coupe',
					'van'          => 'van',
					'microbus'     => 'microbus',
					'cabriolet'    => 'cabriolet',
					'mpv'          => 'mpv',
					'suv'          => 'suv',
					'pickup'       => 'pickup',
					'limousine'    => 'limousine',
					'tank'         => 'tank',
				),
			),
			"requests"  => array(
				"type"  => 'has_many',
				"model" => 'Car\Request'
			),
			"seats"     => array(
				"type" => 'int',
				"is_unsigned" => true,
				"min" => 1,
			),

			"visible"    => array('type' => 'bool'),
			"sent_notif" => array('type' => 'bool'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true,
		);


		public function to_object_with_perms(\System\User $user)
		{
			$data = parent::to_object_with_perms($user);

			if (!$user) {
				unset($data['phone']);
				unset($data['email']);
			}

			return $data;
		}


		public function save()
		{
			if (!$this->ident) {
				$this->ident = md5(time());
			}

			return parent::save();
		}


		public function send_notif(\System\Http\Response $res)
		{
			$body = "Ahoj,\n\nzveřejnili jsme tvojí nabídku na sdílení auta. Na níže uvedené adrese uvidíš jestli se někdo přihlásil a můžeš ji editovat nebo smazat. Pokud se někdo na tvoji nabídku ozve, pošleme ti e-mailem upozornění.";
			$body .= "\n\n";
			$body .= $res->url_full('carshare_admin', array($this->ident));
			$body .= "\n\nHezký den,\norganizační tým Improtřesku 2015\n\nhttp://" . $res->request->host . "\nimprotresk@improliga.cz";

			$mail = new \Helper\Offcom\Mail(array(
				'rcpt'    => array($this->email),
				'subject' => 'Improtřesk 2015 - Sdílení auta',
				'message' => $body
			));

			$mail->send();

			$this->sent_notif = true;
			$this->save();
		}
	}
}
