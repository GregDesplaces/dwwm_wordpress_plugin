<?php
/**
 * If this file is called directly, abort.
 */
defined('ABSPATH') or die('Nothing to see here.');

/**
 * The admin-specific functionality of the plugin.
 * Defines the plugin name, version, and two path for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class GregPluginAdmin {

    /**
     * @var string $name The name of this plugin.
     * @var string $version The version of this plugin.
     * @var string $dir_url The URL of the plugin directory.
     * @var string $dir_path The path of the plugin directory.
     */
    private string $plugin_name;
    private string $version;
    private string $dir_url;
    private string $dir_path;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @param string $dir_url The URL of the plugin directory.
     * @param string $dir_path The path of the plugin directory.
     */
    public function __construct(string $plugin_name, string $version, string $dir_url, string $dir_path) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->dir_url = $dir_url;
        $this->dir_path = $dir_path;


        add_action( 'admin_menu', array( $this, 'add_menu') ); // Add the admin menu
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) ); // Add the admin stylesheet
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) ); // Add the admin scripts
        add_action( 'admin_init', array( $this, 'register_settings' ) ); // Register the settings
    }


    /**
     * Register the stylesheets for the admin area.
     *
     * @returns void
     *
     * @since    1.0.0
     */
    public function enqueue_styles(): void
    {
        wp_enqueue_style( $this->plugin_name . '-admin', $this->dir_url . 'css/greg-plugin-admin.css', array('wp-color-picker'), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @returns void
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(): void
    {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script( $this->plugin_name . '-admin', $this->dir_url . 'js/greg-plugin-back.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
    }

    /**
     * Add the admin menu for this plugin.
     *
     * @returns void
     *
     * @since    1.0.0
     */
    public function add_menu(): void
    {
        add_menu_page(
            __('Greg\'s plugin', 'greg-plugin'),
            __('Greg\'s plugin', 'greg-plugin'),
            'manage_options',
            'greg-plugin',
            array( $this, 'load_render_settings_page'),
            'dashicons-sticky',
            3
        );
    }

    /**
     * Register the settings for this plugin.
     *
     * @returns void
     *
     * @since    1.0.0
     */
    function register_settings(): void
    {
        // Register all settings
        register_setting( 'greg-plugin-settings', 'greg_plugin_is_deactivate' );
        register_setting( 'greg-plugin-settings', 'greg_plugin_content' );
        register_setting( 'greg-plugin-settings', 'greg_plugin_position' );
        register_setting( 'greg-plugin-settings', 'greg_plugin_bg_color' );
        register_setting( 'greg-plugin-settings', 'greg_plugin_text_color' );

        // Add the section for the settings
        add_settings_section(
            'greg_plugin_section',
            '',
            '',
            'greg-plugin'
        );
        // Add the field for deactivation
        add_settings_field(
            'greg_plugin_is_deactivate',
            __('Deactivate the plugin', 'greg-plugin'),
            function() {
                $is_deactivate = get_option( 'greg_plugin_is_deactivate' );
                echo '<input type="checkbox" name="greg_plugin_is_deactivate" value="1" ' . checked( 1, $is_deactivate, false ) . ' />';
            },
            'greg-plugin',
            'greg_plugin_section'
        );
        // Add the field position to the settings page
        add_settings_field(
            'greg_plugin_position',
            __('Position', 'greg-plugin'),
            function() {
                $current_position = get_option( 'greg_plugin_position' );
                if (empty($current_position)) {
                    $current_position = 'bottom';
                    update_option( 'greg_plugin_position', $current_position );
                }
                ?>
                <input type="radio" name="greg_plugin_position" value="bottom" <?php checked( $current_position, 'bottom' ) ?> />
                <label for="bottom"><?php _e('Bottom', 'greg-plugin') ?></label>
                <input type="radio" name="greg_plugin_position" value="top" <?php checked( $current_position, 'top' ) ?> />
                <label for="top"><?php _e('Top', 'greg-plugin') ?></label>
                <?php
            },
            'greg-plugin',
            'greg_plugin_section'
        );
        // Add the section content to the settings page
        add_settings_field(
            'greg_plugin_content',
            __('Content', 'greg-plugin'),
            function() {
                $current_content = esc_html(get_option( 'greg_plugin_content' ));
                if (empty($current_content)) {
                    $current_content = esc_html(__('You should put some text !', 'greg-plugin'));
                    update_option( 'greg_plugin_content', $current_content );
                }
                ?>
                <input type="text" name="greg_plugin_content" value="<?php echo $current_content ?>" class="greg-plugin-large-text-input"/>
                <?php
            },
            'greg-plugin',
            'greg_plugin_section'
        );
        // Add the section background color to the settings page
        add_settings_field(
            'greg_plugin_bg_color',
            __('Background color', 'greg-plugin'),
            function() {
                $current_bg_color = esc_attr(get_option( 'greg_plugin_bg_color' ));
                ?>
                <input
                        class="greg-plugin-color-picker"
                        type="text"
                        name="greg_plugin_bg_color"
                        value="<?= (!empty($current_bg_color)) ? $current_bg_color : '#000000'; ?>"
                />
                <?php
            },
            'greg-plugin',
            'greg_plugin_section'
        );
        // Add the section text color to the settings page
        add_settings_field(
            'greg_plugin_text_color',
            __('Text color', 'greg-plugin'),
            function() {
                $current_text_color = esc_attr(get_option( 'greg_plugin_text_color' ));
                ?>
                <input
                        class="greg-plugin-color-picker"
                        type="text"
                        name="greg_plugin_text_color"
                        value="<?= (!empty($current_text_color)) ? $current_text_color : '#FFFFFF'; ?>"
                <?php
            },
            'greg-plugin',
            'greg_plugin_section'
        );
    }

    /**
     * Load the partial to render the admin page for this plugin.
     *
     * @returns void
     *
     * @since    1.0.0
     */
    public function load_render_settings_page(): void
    {
        include_once( $this->dir_path . 'partials/greg-plugin-admin-display.php' );
    }

}