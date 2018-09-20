<?php

namespace WPGraphQL\Extensions\ACF\Type\Image;

use WPGraphQL\Extensions\ACF\Types as ACFTypes;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class ImageType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct()  {

		self::$type_name = 'fieldImage';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF Image Field.', 'wp-graphql' ),
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
					'id' => [
						'type' => Types::int(),
					],
					'title' => [
						'type' => Types::string(),
					],
					'filename' => [
						'type' => Types::string(),
					],
					'filesize' => [
						'type' => Types::int(),
					],
					'url' => [
						'type' => Types::string(),
					],
					'link' => [
						'type' => Types::string(),
					],
					'alt' => [
						'type' => Types::string(),
					],
					'author' => [
						'type' => Types::string(),
					],
					'description' => [
						'type' => Types::string(),
					],
					'caption' => [
						'type' => Types::string(),
					],
					'name' => [
						'type' => Types::string(),
					],
					'status' => [
						'type' => Types::string(),
					],
					'uploaded_to' => [
						'type' => Types::int(),
					],
					'date' => [
						'type' => Types::string(),
					],
					'modified' => [
						'type' => Types::string(),
					],
					'menu_order' => [
						'type' => Types::int(),
					],
					'mime_type' => [
						'type' => Types::string(),
					],
					'type' => [
						'type' => Types::string(),
					],
					'subtype' => [
						'type' => Types::string(),
					],
					'icon' => [
						'type' => Types::string(),
					],
					'width' => [
						'type' => Types::int(),
					],
					'height' => [
						'type' => Types::int(),
					],
					'sizes' => [
						'type' => Types::list_of( ACFTypes::image_size_type() ),
						'resolve' => function( $field, $args, $context, ResolveInfo $info ) {
							if ( ! empty( $field['sizes'] ) ) {
								$sizes = [];
								
								foreach ( $field['sizes'] as $size_name => $size ) {
									$size_name = explode('-', $size_name);

									if( array_key_exists(1, $size_name) ) {
										$sizes[$size_name[0]][$size_name[1]] = $size;
									} else {
										$sizes[$size_name[0]]['url'] = $size;
									}
								}
							}

							return ! empty( $sizes ) ? $sizes : null;
						},
					],
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}