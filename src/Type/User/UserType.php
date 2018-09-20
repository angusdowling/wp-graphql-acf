<?php

namespace WPGraphQL\Extensions\ACF\Type\User;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class UserType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct() {

		self::$type_name = 'fieldUser';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF User Field.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {

		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
          'ID' => [
            'type' => Types::int(),
          ],
					'user_firstname' => [
						'type' => Types::string(),
					],
					'user_lastname' => [
						'type' => Types::string(),
          ],
					'nickname' => [
						'type' => Types::string(),
          ],
					'user_nicename' => [
						'type' => Types::string(),
          ],
					'display_name' => [
						'type' => Types::string(),
          ],
					'user_email' => [
						'type' => Types::string(),
          ],
					'user_url' => [
						'type' => Types::string(),
          ],
					'user_registered' => [
						'type' => Types::string(),
          ],
					'user_description' => [
						'type' => Types::string(),
          ],
					'user_avatar' => [
						'type' => Types::string(),
          ],
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}