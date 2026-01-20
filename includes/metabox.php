<?php
defined('ABSPATH') || exit;
add_action('add_meta_boxes', function () {
    add_meta_box('sblh_broken_links', __('Broken Links', 'sblh'), 'sblh_render_metabox', null, 'side');
});
function sblh_render_metabox($post){
    $links = (array) get_post_meta($post->ID, '_sblh_broken_links', true);
    wp_nonce_field('sblh_nonce', 'sblh_nonce_field');
    if (empty($links)) { echo esc_html__('No broken links found.', 'sblh'); return; }
    echo '<ul>';
    foreach ($links as $url => $status) {
        echo '<li><code>' . esc_url($url) . '</code><br>Status: ' . esc_html($status);
        echo '<br><button class="button sblh-ignore" data-post="' . esc_attr($post->ID) . '" data-url="' . esc_attr($url) . '">Dismiss</button></li><hr>';
    }
    echo '</ul>';
}
