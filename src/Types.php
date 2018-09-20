<?php

namespace WPGraphQL\Extensions\ACF;

use WPGraphQL\Extensions\ACF\Type\Field\FieldType;
use WPGraphQL\Extensions\ACF\Type\FieldGroup\FieldGroupType;
use WPGraphQL\Extensions\ACF\Type\Union\FieldUnionType;
use WPGraphQL\Extensions\ACF\Type\File\FileType;
use WPGraphQL\Extensions\ACF\Type\Image\ImageType;
use WPGraphQL\Extensions\ACF\Type\Image\ImageSizeType;
use WPGraphQL\Extensions\ACF\Type\Link\LinkType;
use WPGraphQL\Extensions\ACF\Type\Map\MapType;
use WPGraphQL\Extensions\ACF\Type\User\UserType;

class Types {
	private static $field_type;
	private static $field_group_type;
	private static $field_union_type;
	private static $file_type;
	private static $image_type;
	private static $image_size_type;
	private static $link_type;
	private static $map_type;
	private static $user_type;

	public static function field_type( $type ) {

		if ( null === self::$field_type ) {
			self::$field_type = [];
		}

		if ( ! empty( $type['graphql_label'] ) && empty( self::$field_type[ $type['graphql_label'] ] ) ) {
			self::$field_type[ $type['graphql_label'] ] = new FieldType( $type );
		}

		return ! empty( self::$field_type[ $type['graphql_label'] ] ) ? self::$field_type[ $type['graphql_label'] ] : null;
		
	}

	public static function field_group_type() {
		return self::$field_group_type ? : ( self::$field_group_type = new FieldGroupType() );
	}

	public static function field_union_type() {
		return self::$field_union_type ? : ( self::$field_union_type = new FieldUnionType() );
	}
	
	public static function file_type() {
		return self::$file_type ? : ( self::$file_type = new FileType() );
	}

	public static function image_type() {
		return self::$image_type ? : ( self::$image_type = new ImageType() );
	}

	public static function image_size_type() {
		return self::$image_size_type ? : ( self::$image_size_type = new ImageSizeType() );
	}

	public static function link_type() {
		return self::$link_type ? : ( self::$link_type = new LinkType() );
	}

	public static function map_type() {
		return self::$map_type ? : ( self::$map_type = new MapType() );
	}

	public static function user_type() {
		return self::$user_type ? : ( self::$user_type = new UserType() );
	}
}
