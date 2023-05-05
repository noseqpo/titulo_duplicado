<?php
function check_titulo_duplicado_error($data, $postarr)
{
    if ('publish' !== $data['post_status']) {
        return $data;
    }

    global $wpdb;
    $existing_posts = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->posts} WHERE post_title = %s AND post_type = %s AND ID != %d AND post_status = %s",
            $data['post_title'], 'post', $postarr['ID'], 'publish'
        )
    );

    if (!empty($existing_posts)) {
        wp_die('Error: El título de la entrada ya existe. Por favor, elige un título diferente.');
    }

    return $data;
}
add_filter('wp_insert_post_data', 'check_titulo_duplicado_error', 10, 2);
