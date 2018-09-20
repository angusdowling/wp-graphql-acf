<?php
namespace WPGraphQL\Extensions\ACF\Type\Field;

use \WPGraphQL\Extensions\ACF\Types as ACFTypes;
use WPGraphQL\Extensions\ACF\Utils as ACFUtils;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQLRelay\Relay;
use WPGraphQL\AppContext;
use WPGraphQL\Type\WPObjectType;
use WPGraphQL\Types;

class FieldType extends WPObjectType {

	private $fields;
	private $type_name;
	private $type;
	private $field_type;

	public function __construct( $type ) {

		/**
		 * Set the name of the field
		 */
		$this->type = $type;
		$this->type_name = ! empty( $this->type['graphql_label'] ) ? 'acf' . ucwords( $this->type['graphql_label'] ) . 'Field' : null;
		$this->field_type = self::get_field_type( $this->type );

		/**
		 * Merge the fields passed through the config with the default fields
		 */
		$config = [
			'name' => $this->type_name,
			'fields' => $this->fields( $this->type ),
			// Translators: the placeholder is the name of the ACF Field type
			'description' => sprintf( __( 'ACF Field of the %s type', 'wp-graphql-acf' ), $this->type_name ),
			'interfaces'  => [ self::node_interface() ],
		];

		parent::__construct( $config );

	}

	private function fields( $type ) {

		if ( null === $this->fields ) {
			$this->fields = [];
		}

		if ( empty( $this->fields[ $type['graphql_label'] ] ) ) {
			$this->fields[ $type['graphql_label'] ] = function() use ( $type ) {
				$fields = [
					'id' => [
						'type' => Types::non_null( Types::id() ),
						'description' => __( 'The global ID for the field', 'wp-graphql-acf' ),
						'resolve' => function( array $field, array $args, AppContext $context, ResolveInfo $info ) {
							return ( ! empty( $field['ID'] ) && absint( $field['ID'] ) ) ? Relay::toGlobalId( $this->type_name, $field['ID'] ) : null;
						},
					],
					$type['graphql_label'] . 'Id' => [
						'type' => Types::non_null( Types::int() ),
						'description' => __( 'The database ID for the field', 'wp-graphql-acf' ),
						'resolve' => function( array $field ) {
							return ( ! empty( $field['ID'] ) && absint( $field['ID'] ) ) ? absint( $field['ID'] ) : null;
						},
					],
					'label' => [
						'type' => Types::non_null( Types::string() ),
						'description' => __( 'This is the name which will appear on the EDIT page', 'wp-graphql-acf' ),
					],
					'name' => [
						'type' => Types::non_null( Types::string() ),
						'description' => __( 'The name of the field. Single word, no spaces. Underscores and dashes allowed.', 'wp-graphql-acf' ),
					],
					'instructions' => [
						'type' => Types::string(),
						'description' => __( 'Instructions for authors. Shown when submitting data', 'wp-graphql-acf' ),
					],
					'prefix' => [
						'type' => Types::string(),
					],
					'value' => [
						'type' => $this->field_type,
						'resolve' => function( array $field ) {
							return $this->format_field( $field );
						},
					],
					'required' => [
						'type' => Types::boolean(),
					],
					'key' => [
						'type' => Types::string(),
					],
					'class' => [
						'type' => Types::string(),
					],
				];

				return self::prepare_fields( $fields, $type['graphql_label'] );

			};

		} // End if().

		return ! empty( $this->fields[ $type['graphql_label'] ] ) ? $this->fields[ $type['graphql_label'] ] : null;

	}

	private function get_field_type( $type ) {
		switch( $type['name'] ) {
			case 'text':
			case 'textarea':
			case 'email':
			case 'url':
			case 'password':
			case 'wysiwyg':
			case 'oembed':
			case 'select':
			case 'radio':
			case 'button_group':
			case 'page_link':
			case 'date_picker':
			case 'date_time_picker':
			case 'time_picker':
			case 'color_picker':
			case 'tab':
			case 'message':
			case 'accordion':
				return Types::string();
				break;

			case 'checkbox':
				return Types::list_of( Types::string() );
				break;

			case 'number':
			case 'range':
				return Types::int();
				break;
			
			case 'true_false':
				return Types::boolean();
				break;
				
			case 'image':
				return ACFTypes::image_type();
				break;
			
			case 'gallery':
				return Types::list_of( ACFTypes::image_type() );
				break;
				
			case 'file':
				return ACFTypes::file_type();
				break;
			
			case 'link':
				return ACFTypes::link_type();
				break;

			case 'post_object':
				return Types::post_object_union();
				break;
			
			case 'relationship':
				return Types::list_of( Types::post_object_union() );
				break;
			
			case 'taxonomy':
				return Types::list_of( Types::int() );
				break;
			
			case 'user':
				return ACFTypes::user_type();
				break;

			case 'group':
			case 'flexible_content':
			case 'repeater':
			case 'clone':
				return Types::list_of( ACFTypes::field_group_type() );
				break;
			
			case 'google_map':
				return ACFTypes::map_type();
				break;
		}
	}

	private function format_sub_fields( $field ) {
		if( have_rows( $field['key'] ) ):
			$items = array();

			while ( have_rows( $field['key'] ) ) : the_row();
				$row = get_row();

				$item = array(
					'fields' => []
				);

				foreach($row as $key => $row_item):
					if($key == 'acf_fc_layout'):
						$item[ACFUtils::_graphql_label( $key )] = $row_item;
					else:
						$acf_field                  = get_sub_field_object($key);
						$type                       = (array) acf_get_field_type( $acf_field['type'] );
						$acf_field['graphql_label'] = ACFUtils::_graphql_label( $type['name'] );
						$acf_field['object_id']     = $field['object_id'];

						array_push($item['fields'], $acf_field);
					endif;
				endforeach;

				array_push($items, $item);
				
			endwhile;

			return $items;
		endif;
	}

	private function format_field( $field ) {
		switch( $field['type'] ) {
			case 'flexible_content':
			case 'repeater':
			case 'group':
			case 'clone':
				return $this->format_sub_fields( $field );
				break;
		}

		if( !empty($field['value'] ) ) {
			return $field['value'];
		}

		return get_field( $field['key'], $field['object_id'], true );
	}

}
