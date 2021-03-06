<?php

namespace WPGraphQL\Extensions\ACF\Type\Link;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class LinkType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct() {

		self::$type_name = 'fieldLink';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF Link Field.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {

		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
          'title' => [
            'type' => Types::string(),
          ],
					'url' => [
						'type' => Types::string(),
					],
					'target' => [
						'type' => Types::string(),
					]
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}