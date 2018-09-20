<?php

namespace WPGraphQL\Extensions\ACF;

use WPGraphQL\Extensions\ACF\Utils as ACFUtils;

class Filters {
  /**
	 * Adds a "graphql_label" to each field when acf_get_fields() is called
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	public static function acf_get_fields( $fields ) {

		if ( empty( $fields ) || ! is_array( $fields ) ) {
			return $fields;
		}

		foreach ( $fields as $key => $field ) {

			$graphql_label                   = ACFUtils::_graphql_label( $field['name'] );
			$fields[ $key ]['graphql_label'] = $graphql_label . 'Field';

		}

		return $fields;
	}
}