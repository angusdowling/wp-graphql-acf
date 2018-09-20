<?php

namespace WPGraphQL\Extensions\ACF\Type\Map;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class MapType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct() {

		self::$type_name = 'fieldMap';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF Map Field.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {

		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
          'address' => [
            'type' => Types::string(),
          ],
					'lat' => [
						'type' => Types::string(),
					],
					'lng' => [
						'type' => Types::string(),
					]
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}