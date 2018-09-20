<?php

namespace WPGraphQL\Extensions\ACF\Type\File;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class FileType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct() {

		self::$type_name = 'fieldFile';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF File Field.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {

		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
					'id' => [
						'type' => Types::int(),
					],
					'url' => [
						'type' => Types::string(),
					],
					'title' => [
						'type' => Types::string(),
					],
					'alt' => [
						'type' => Types::string(),
					],
					'description' => [
						'type' => Types::string(),
					],
					'name' => [
						'type' => Types::string(),
					],
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}