<?php

namespace WPGraphQL\Extensions\ACF\Type\Image;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class ImageSizeType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct() {

		self::$type_name = 'fieldImageSize';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF Image Sizes for Image Type.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {
		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
					'url' => [
						'type' => Types::string(),
					],
					'height' => [
						'type' => Types::int(),
					],
					'width' => [
						'type' => Types::int(),
					],
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;
	}
}