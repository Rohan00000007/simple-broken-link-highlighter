<?php
defined('ABSPATH') || exit;
add_action('admin_menu', function () {
    add_management_page('Broken Links', 'Broken Links', 'manage_options', 'sblh-broken-links', 'sblh_tools_page');
});
function sblh_tools_page(){
    global $wpdb;
    $rows = $wpdb->get_results("SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key='_sblh_broken_links' AND meta_value != ''");
    echo '<div class="wrap"><h1>Broken Links</h1><button class="button" id="sblh-bulk-recheck">Bulk Recheck</button><table class="widefat"><tbody>';
    foreach ($rows as $row) {
        $links = maybe_unserialize($row->meta_value);
        echo '<tr><td><input type="checkbox" class="sblh-post" value="' . esc_attr($row->post_id) . '"> ' . esc_html(get_the_title($row->post_id)) . '</td><td>';
        foreach ($links as $url => $status) echo esc_url($url) . ' (' . esc_html($status) . ')<br>';
        echo '</td></tr>';
    }
    echo '</tbody></table></div>';
}
