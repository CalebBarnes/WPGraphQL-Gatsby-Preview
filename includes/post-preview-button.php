<?php

add_filter('preview_post_link', 'custom_preview_page_link');

function custom_preview_page_link($link) {
    // TODO: Add active template to the link
    parse_str(parse_url($link, PHP_URL_QUERY), $params);
    
    $post_type;
    // get the actual post type of this preview revision
    if (isset($params['preview_id'])) {
        $preview_id = $params['preview_id'];
        $post_type = get_post_type($preview_id);
    }
    
    if (isset($params['page_id'])) {
        $page_id = $params['page_id'];
        $post_type = get_post_type($page_id);
    }

    $id = get_the_ID();
    // Get the jwtAuthToken of the current user and the the wp graphql id of the preview revision
    if (function_exists('graphql')) {
        $graphql = graphql([
                    'query' => "{
                                    viewer {
                                        jwtAuthToken
                                    }
                                    post(id: $id, idType:DATABASE_ID) {
                                        id
                                    }
                                }"
                    ]);

        $jwtAuthToken = $graphql['data']['viewer']['jwtAuthToken'];  
        $graphql_page_id = $graphql['data']['post']['id'];
    }

    $link = get_home_url() . "/preview/?preview=true&post_type=$post_type&id=$graphql_page_id&key=$jwtAuthToken";

	return $link;
}

?>