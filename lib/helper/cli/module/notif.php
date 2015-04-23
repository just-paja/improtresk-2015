<?

namespace Helper\Cli\Module
{
	class Notif extends \Helper\Cli\Module
	{
		protected static $info = array(
			'name' => 'bank',
			'head' => array(
				'Manage your account transactions',
			),
		);


		protected static $attrs = array(
			"help"    => array("type" => 'bool', "value" => false, "short" => 'h', "desc"  => 'Show this help'),
			"verbose" => array("type" => 'bool', "value" => false, "short" => 'v', "desc" => 'Be verbose'),
		);


		protected static $commands = array(
			"match" => array('Send notification about match survey'),
			"lunch" => array('Send notification about lunch picker'),
		);


		public function cmd_lunch()
		{
			\System\Init::full();

			$users = \Workshop\SignUp::get_all()
				->where(array(
					"sent_lunch" => false,
					"solved" => true,
					"lunch" => true
				))
				->fetch();

			\Helper\Cli::do_over($users, function($key, $user) {
				$ren = new \System\Template\Renderer\Txt();
				$ren->reset_layout();
				$ren->partial('mail/notif/lunch', array(
					"user"   => $user,
					"symvar" => $user->check->symvar
				));

				$mail = new \Helper\Offcom\Mail(array(
					'rcpt'     => array($user->email),
					'subject'  => 'Improtřesk 2015 - Výběr oběda',
					'reply_to' => \System\Settings::get('offcom', 'default', 'reply_to'),
					'message'  => $ren->render_content()
				));

				$mail->send();

				$user->sent_lunch = true;
				$user->save();
			});
		}


		public function cmd_match()
		{
			\System\Init::full();

			$users = \Workshop\SignUp::get_all()
				->where(array(
					"sent_match" => false,
					"solved" => true
				))
				->fetch();

			\Helper\Cli::do_over($users, function($key, $user) {
				$ren = new \System\Template\Renderer\Txt();
				$ren->reset_layout();
				$ren->partial('mail/notif/match', array(
					"user"   => $user,
					"symvar" => $user->check->symvar
				));

				$mail = new \Helper\Offcom\Mail(array(
					'rcpt'     => array($user->email),
					'subject'  => 'Improtřesk 2015 - Týmy na zápas',
					'reply_to' => \System\Settings::get('offcom', 'default', 'reply_to'),
					'message'  => $ren->render_content()
				));

				$mail->send();

				$user->sent_match = true;
				$user->save();
			});
		}
	}
}

