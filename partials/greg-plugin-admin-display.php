<?php

/**
 * If this file is called directly, abort.
 */
defined('ABSPATH') or die('Nothing to see here.');
?>

<div class="wrap">

    <h2><?= esc_html(get_admin_page_title()) ?></h2>
    <p><?php _e('You are on the plugin settings main page !', 'greg-plugin') ?></p>
    <form method="post" action="options.php">
        <?php
        settings_fields('greg-plugin-settings');
        do_settings_sections('greg-plugin');
        submit_button();
        ?>
    </form>
</div>
