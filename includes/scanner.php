<?php
defined('ABSPATH') || exit;
add_action('save_post', 'sblh_scan_links_on_save', 10, 2);
function sblh_scan_links_on_save($post_id, $post){
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return;
    if (!current_user_can('edit_post', $post_id)) return;
    preg_match_all('/<a\s[^>]*href=["\']([^"\']+)["\']/i', $post->post_content, $matches);
    $links = array_unique($matches[1] ?? []);
    $broken = [];
    $ignored = (array) get_post_meta($post_id, '_sblh_ignored_links', true);
    foreach ($links as $url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) continue;
        if (parse_url($url, PHP_URL_HOST) === parse_url(home_url(), PHP_URL_HOST)) continue;
        if (in_array($url, $ignored, true)) continue;
        $response = wp_remote_head($url, ['timeout' => 5]);
        if (is_wp_error($response)) { $broken[$url] = 'timeout'; continue; }
        $code = wp_remote_retrieve_response_code($response);
        if ($code >= 400) $broken[$url] = $code;
        usleep(300000);
    }
    update_post_meta($post_id, '_sblh_broken_links', $broken);
}
