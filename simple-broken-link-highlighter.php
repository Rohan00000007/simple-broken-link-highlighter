<?php
/**
 * Plugin Name: Simple Broken Link Highlighter
 * Description: Detects broken external links on post save and highlights them in the editor.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: sblh
 */
defined('ABSPATH') || exit;

define('SBLH_PATH', plugin_dir_path(__FILE__));
define('SBLH_URL', plugin_dir_url(__FILE__));

require_once SBLH_PATH . 'includes/scanner.php';
require_once SBLH_PATH . 'includes/metabox.php';
require_once SBLH_PATH . 'includes/ajax.php';
require_once SBLH_PATH . 'includes/tools-page.php';

add_action('admin_enqueue_scripts', function ($hook) {
    if (in_array($hook, ['post.php', 'post-new.php', 'tools_page_sblh-broken-links'], true)) {
        wp_enqueue_script('sblh-admin', SBLH_URL . 'assets/admin.js', ['jquery'], '1.0.0', true);
        wp_localize_script('sblh-admin', 'sblhData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('sblh_nonce'),
        ]);
    }
});
