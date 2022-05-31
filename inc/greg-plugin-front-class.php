<?php

/**
 * Class greg_plugin_front
 *
 * @author Greg
 * @version 1.0
 * @package greg-plugin
 * @category Class
 * @license GPL
 * @since 1.0
 *
 */
class GregPluginFront
{
    /**
     * @var string $plugin_name The name of this plugin.
     * @var string $version The plugin version
     * @var string $plugin_dir The plugin directory
     * @var string $plugin_url The plugin url
     */
    private string $plugin_name;
    private string $version;
    private string $dir_url;
    private string $dir_path;

    /**
     * Constructor
     *
     * @param string $plugin_name
     * @param string $version
     * @param string $dir_url
     * @param string $dir_path
     */
    public function __construct(string $plugin_name, string $version, string $dir_url, string $dir_path) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->dir_url = $dir_url;
        $this->dir_path = $dir_path;

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_and_styles'));
    }

    /**
     * Enqueue scripts and styles and send data to the js file
     *
     * @return void
     */
    public function enqueue_scripts_and_styles(): void
    {
        wp_enqueue_style($this->plugin_name . '-front', $this->dir_url . 'css/greg-plugin-front.css', array(), $this->version, 'all');
        wp_enqueue_script($this->plugin_name . '-front', $this->dir_url . 'js/greg-plugin-front.js', array('jquery'), $this->version, true);
        wp_localize_script($this->plugin_name . '-front', 'settings', array(
            'isActive' => !get_option('greg_plugin_is_deactivate'),
            'position' => esc_html(get_option('greg_plugin_position')),
            'content' => esc_html(get_option('greg_plugin_content')),
            'bgColor' => esc_attr(get_option('greg_plugin_bg_color')),
            'textColor' => esc_attr(get_option('greg_plugin_text_color')),
        ));
    }

}