<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class Testimonial_Addons_For_Elementor {

    const MINIMUM_ELEMENTOR_VERSION = '2.5.0';
    const MINIMUM_PHP_VERSION = '7.0';
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action('wp_enqueue_scripts', [ $this,'testimonial_for_elementor_assets'] );
    }
    public function i18n() {
        load_plugin_textdomain( 'testimonial-fe', false, dirname( plugin_basename( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_ROOT ) ) . '/languages/' );

    }
    public function init() {
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Call Includes File
        $this->includes();

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }

    /*
    * Check Plugins is Installed or not
    */
    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    /**
     * Admin notice.
     * For missing elementor.
     */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );
            $message = sprintf( esc_html__( '%1$sTestimonial Addons for Elementor%2$s requires %1$s"Elementor"%2$s plugin to be active. Please activate Elementor to continue.', 'testimonial-fe' ), '<strong>', '</strong>' );
            $button_text = esc_html__( 'Activate Elementor', 'testimonial-fe' );
        } else {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
            $message = sprintf( esc_html__( '%1$sTestimonial Addons for Elementor%2$s requires %1$s"Elementor"%2$s plugin to be installed and activated. Please install Elementor to continue.', 'testimonial-fe' ), '<strong>', '</strong>' );
            $button_text = esc_html__( 'Install Elementor', 'testimonial-fe' );
        }
        $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
        printf( '<div class="error"><p>%1$s</p>%2$s</div>', $message, $button );
    }

    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'testimonial-fe' ),
            '<strong>' . esc_html__( 'Testimonial For Elementor Addons', 'testimonial-fe' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'testimonial-fe' ) . '</strong>',
             self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'testimonial-fe' ),
            '<strong>' . esc_html__( 'Testimonial For Elementor Addons', 'testimonial-fe' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'testimonial-fe' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function testimonial_for_elementor_assets(){
        self::plugin_css();
        self::plugin_js();
    }

    public function plugin_css(){
        
        wp_enqueue_style('testimonial-fe-widgets', TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_URL.'assets/css/testimonial-for-elementor-widgets.css', '', TESTIMONIAL_FOR_ELEMENTOR_VERSION );

        // Slick css
        wp_enqueue_style(
            'slick-slider',
            TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_URL . 'assets/css/slick.min.css'
        );

    }

    public function plugin_js(){

       // Slick js
        wp_enqueue_script(
            'slick-slider',
            TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_URL . 'assets/js/slick.min.js',array('jquery'), '', true 
        );

        // Testimonial Active JS
        wp_enqueue_script(
            'testimonial-widgets',
            TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_URL . 'assets/js/testimonial-widgets-active.js',array('jquery'), '', true 
        );

    }

    public function init_widgets() {
        // Include Widget files
        include( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_PATH.'/include/elementor_widgets.php' );
        // Register widget
         \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Testimonial_For_Elementor_Widget() );
    }

    // Include Icon files
    public function includes() {
        require_once ( TESTIMONIAL_FOR_ELEMENTOR_ADDONS_PL_PATH.'include/class.testimonial-icon-manager.php' );
    }

}
Testimonial_Addons_For_Elementor::instance();
