<?php wp_head(); 

global $post;

console_log($post);

$post_id = $post->ID;
$post_type = $post->post_type;
$revision = array_values( wp_get_post_revisions( $post_id ) )[0] ?? null;
console_log($revision);
$revision_id;

if (isset($revision)) {
    $revision_id = $revision->ID;
} 
// else if (isset($post_id)) {
//     $revision_id = $post_id;
// }

console_log(['revision_id' => $revision_id]);
// console_log(['post_id' => $post_id]);
// console_log(['post_type' => $post_type]);
// console_log(['post' => $post]);
// console_log(['revision' => $revision]);

if (function_exists('graphql')) {
    $graphql = graphql([
                'query' => "{
                                viewer {
                                    jwtAuthToken
                                }
                                post(id: $revision_id, idType:DATABASE_ID) {
                                    id
                                }
                            }"
                ]);

    console_log($graphql);

    $jwtAuthToken;
    $graphql_page_id;

    if (isset($graphql)) {
        $jwtAuthToken = $graphql['data']['viewer']['jwtAuthToken'];
        $graphql_page_id = $graphql['data']['post']['id'];
    }

    console_log($jwtAuthToken);
}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview</title>
    <style>
    /* #wpadminbar,
    .gp-actions {
        display: none;
    } */

    iframe {
        position: fixed;
        top: 32px;
        left: 0;
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
    <!-- <?php $frontend_url = GATSBY_PREVIEW_FRONTEND_URL; ?> -->
    <?php $frontend_url = 'https://wp-gatsby-demo-1.netlify.app'; ?>
    <?php $frontend_url_trailing_slash = rtrim($frontend_url, '/') . '/'; ?>
    <?php $frontend_url_no_trailing_slash = rtrim($frontend_url, '/'); ?>

    <?php if ($frontend_url): ?>
    <iframe id='preview' src="<?= $frontend_url_trailing_slash;
     ?>preview/types/<?= $post_type; ?>?id=<?= $graphql_page_id ?>&key=<?= $jwtAuthToken; ?>&no-cache=1" frameborder="0"></iframe>
    <?php endif; ?>
</body>

</html>
<?php wp_footer(); ?>