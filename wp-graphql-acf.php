<?php
/**
 * Plugin Name:     WPGraphQL ACF
 * Description:     Adds Advanced Custom Fields to the WPGraphQL Schema
 * Author:          WPGraphQL, Toni Main, Jason Bahl, Angus Dowling
 * Text Domain:     wp-graphql-acf
 * Domain Path:     /languages
 * Version:         0.0.1
 *
 * @package         WPGraphQL_ACF
 */

namespace WPGraphQL\Extensions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( '\WPGraphQL\Extensions\ACF' ) ) :

final class ACF {

  /**
   * @var ACF The single instance of the class
   */
  protected static $_instance = null;

  /**
   * Main ACF Instance
   *
   * Ensures only one instance of ACF is loaded or can be loaded.
   *
   * @static
   * @see ACF()
   * @return ACF - Main instance
   */
  public static function instance() {

    if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof ACF ) ) {
      self::$_instance = new self();
      self::$_instance->constants();
      self::$_instance->includes();
      self::$_instance->filters();
      self::$_instance->actions();
    }

    /**
     * Fire off init action
     *
     * @param ACF $instance The instance of the WPGraphQL\Extensions\ACF class
     */
    do_action( 'graphql_acf_init', self::$_instance );

    return self::$_instance;

  }

  /**
   * Throw error on object clone.
   * The whole idea of the singleton design pattern is that there is a single object
   * therefore, we don't want the object to be cloned.
   *
   * @access public
   * @return void
   */
  public function __clone() {

    // Cloning instances of the class is forbidden.
    _doing_it_wrong( __FUNCTION__, esc_html__( 'The \WPGraphQL\Extensions\ACF class should not be cloned.', 'wp-graphql-acf' ), '0.0.1' );

  }

  /**
   * Disable unserializing of the class.
   *
   * @access protected
   * @return void
   */
  public function __wakeup() {

    // De-serializing instances of the class is forbidden.
    _doing_it_wrong( __FUNCTION__, esc_html__( 'De-serializing instances of the \WPGraphQL\Extensions\ACF class is not allowed', 'wp-graphql-acf' ), '0.0.1' );

  }

  /**
   * Constants.
   */
  private function constants() {

			// Plugin Folder Path.
			if ( ! defined( 'ACF_PLUGIN_DIR' ) ) {
				define( 'ACF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
      }
      
  }

  /**
   * Include required core files.
   */
  private function includes() {

    // Autoload Required Classes
    require_once( ACF_PLUGIN_DIR . 'vendor/autoload.php' );

  }

  private function actions() {

    add_action( 'do_graphql_request', [ '\WPGraphQL\Extensions\ACF\Actions', 'acf_add_fields_to_types' ] );
    
  }

  private function filters() {

    add_filter( 'acf/get_fields', [ '\WPGraphQL\Extensions\ACF\Filters', 'acf_get_fields' ], 100 );
    
  }
}

endif;

function init() {
  if(!class_exists('acf')) {
      add_action( 'admin_notices', function() {
          ?>
          <div class="error notice">
              <p><?php _e( 'Advanced custom fields must be active for wp-graphql-acf to work', 'wp-graphiql-acf' ); ?></p>
          </div>
          <?php
      });
      return false;
  }

return ACF::instance();
}

add_action( 'graphql_init', '\WPGraphQL\Extensions\init' );