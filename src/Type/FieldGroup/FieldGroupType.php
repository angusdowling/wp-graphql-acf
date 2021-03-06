<?php

namespace WPGraphQL\Extensions\ACF\Type\FieldGroup;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;
use WPGraphQL\Extensions\ACF\Types as ACFTypes;

class FieldGroupType extends WPObjectType {

	private static $type_name;

	private static $fields;

	public function __construct()  {

		self::$type_name = 'fieldGroup';

		$config = [
			'name'        => self::$type_name,
			'fields'      => self::fields(),
			'description' => __( 'ACF Group Field.', 'wp-graphql' ),
		];

		parent::__construct( $config );

	}

	private static function fields() {

		if ( null === self::$fields ) {
			self::$fields = function() {
				$fields = [
          'acfFcLayout' => [
						'type' => Types::string(),
					],
					'fields' => [
						'type' => Types::list_of( ACFTypes::field_union_type() ),
					],
				];

				return self::prepare_fields( $fields, self::$type_name );

			};
		}

		return self::$fields;

	}
}