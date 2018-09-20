<?php
namespace WPGraphQL\Extensions\ACF\Type\Union;

use WPGraphQL\Type\WPUnionType;
use WPGraphQL\Types;
use WPGraphQL\Extensions\ACF\Types as ACFTypes;
use WPGraphQL\Extensions\ACF\Utils as ACFUtils;

class FieldUnionType extends WPUnionType {

	private $possible_types;

	public function __construct() {

		$config = [
			'name' => 'fieldUnion',
			'types' => function() {
				return $this->getPossibleTypes();
			},
			'resolveType' => function( $field ) {
				return ! empty( $field ) ? ACFTypes::field_type( $field ) : null;
			},
		];

		parent::__construct( $config );
	}

	public function getPossibleTypes() {

		if ( null === $this->possible_types ) {
			$this->possible_types = [];
		}

		$acf_field_types = acf_get_field_types();

		if ( ! empty( $acf_field_types ) && is_array( $acf_field_types ) ) {
			foreach ( $acf_field_types as $type_key => $type ) {
				$type = (array) $type;
				$type['graphql_label'] = ACFUtils::_graphql_label( $type_key );

				if ( ! empty( $type['graphql_label'] ) && empty( $this->possible_types[ $type['graphql_label'] ] ) ) {
					$this->possible_types[ $type['graphql_label'] ] = ACFTypes::field_type( $type );
				}
			}
		}

		return ! empty( $this->possible_types ) ? $this->possible_types : null;

	}

	public function getResolveTypeFn() {
		return $this->resolveTypeFn;
	}

}
