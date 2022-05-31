<?php
/**
 * If this file is called directly, abort.
 */


defined('ABSPATH') or die('Nothing to see here.');

/**
 * The code that runs during plugin activation.
 *
 * @param    string    $version   The version of the plugin that is being activated.
 *
 * @since    1.0.0
 */
class GregPlugin {
    /**
     * @var string The plugin name
     */
    protected string $name = 'greg-plugin';
    /**
     * @var string The plugin version
     */
    protected string $version = '1.0';

    /**
     * @var string The plugin url
     */
    protected string  $plugin_dir_url = '';

    /**
     * @var string The plugin path
     */
    protected string  $plugin_dir_path = '';

    /**
     * The constructor for this class. Don't call this directly, see get_instance() instead.
     * This is done so that WP_Error objects can be returned during class initiation.
     *
     * @return void
     * @since 1.0
     *
     */
    public function __construct() {
        add_action( 'init', array( $this, 'init') );
    }


    /**
     * Load the plugin directory url
     *
     * @return string $this->plugin_dir_url
     * @since    1.0.0
     *
     */
    private function get_plugin_dir_url(): string
    {
        if ( ! $this->plugin_dir_url ) {
            $this->plugin_dir_url = plugin_dir_url( __FILE__ ) . '../';
        }
        return $this->plugin_dir_url;
    }

    /**
     * Load the plugin directory absolute path
     *
     * @return string $this->plugin_dir_path
     * @since    1.0.0
     *
     */
    private function get_plugin_dir_path(): string
    {
        if ( ! $this->plugin_dir_path ) {
            $this->plugin_dir_path = dirname( __FILE__, 2 ) . '/';
        }
        return $this->plugin_dir_path;
    }


    /**
     * Load the plugin text domain for translation.
     *
     * @return void
     * @since 1.0
     *
     */
    public function load_plugin_text_domain(): void
    {
        load_plugin_textdomain( $this->name, false, $this->get_plugin_dir_path() . 'languages/' );
    }

    /**
     * Load the plugin back scripts and styles.
     *
     * @return void
     * @since 1.0
     *
     */
    public function load_plugin_back_settings(): void
    {
        require_once $this->get_plugin_dir_path() . 'inc/greg-plugin-admin-class.php';
        new GregPluginAdmin($this->name, $this->version, $this->get_plugin_dir_url(), $this->get_plugin_dir_path());
    }

    /**
     * Load the plugin front scripts and styles.
     *
     * @return void
     * @since 1.0
     *
     */
    public function load_plugin_front(): void
    {
        require_once $this->get_plugin_dir_path() . 'inc/greg-plugin-front-class.php';
        new GregPluginFront($this->name, $this->version, $this->get_plugin_dir_url(), $this->get_plugin_dir_path());
    }

    /**
     * Initialize the plugin by
     * creating an instance of the classes GregPluginBack and GregPluginFront
     * and loading the text domain.
     *
     * @return void
     */
    public function init(): void
    {
        $this->load_plugin_text_domain();
        $this->load_plugin_back_settings();
        $this->load_plugin_front();
    }

}