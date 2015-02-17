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
			"visible" => array('type' => 'bool')
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
	}
}