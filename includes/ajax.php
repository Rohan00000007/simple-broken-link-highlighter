<?php
defined('ABSPATH') || exit;
add_action('wp_ajax_sblh_ignore_link', 'sblh_ignore_link');
add_action('wp_ajax_sblh_bulk_recheck', 'sblh_bulk_recheck');
function sblh_ignore_link(){
    check_ajax_referer('sblh_nonce', 'nonce');
    $post_id = absint($_POST['post_id']);
    $url = esc_url_raw($_POST['url']);
    $ignored = (array) get_post_meta($post_id, '_sblh_ignored_links', true);
    $ignored[] = $url;
    update_post_meta($post_id, '_sblh_ignored_links', array_unique($ignored));
    wp_send_json_success();
}
function sblh_bulk_recheck(){
    check_ajax_referer('sblh_nonce', 'nonce');
    foreach ((array) $_POST['posts'] as $post_id) {
        $post = get_post(absint($post_id));
        if ($post) sblh_scan_links_on_save($post->ID, $post);
    }
    wp_send_json_success();
}
