<?php wp_head(); ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview</title>
    <style>
    #wpadminbar,
    .gp-actions {
        display: none;
    }

    iframe {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
    <?php $post_type = htmlspecialchars($_GET['post_type']); ?>
    <?php $id = htmlspecialchars($_GET['id']); ?>
    <?php $key = htmlspecialchars($_GET['key']); ?>
    <?php $query_vars = htmlspecialchars($_SERVER['QUERY_STRING']); ?>

    <?php error_log($id);?>
    <?php error_log($key);?>

    <?php $frontend_url = GATSBY_PREVIEW_FRONTEND_URL; ?>
    <?php $frontend_url_trailing_slash = rtrim($frontend_url, '/') . '/'; ?>
    <?php $frontend_url_no_trailing_slash = rtrim($frontend_url, '/'); ?>

    <?php if ($frontend_url): ?>
    <iframe id='preview' src="<?= $frontend_url_trailing_slash;
     ?>preview/types/<?= $post_type; ?>?id=<?= $id ?>&key=<?= $key; ?>&no-cache=1" frameborder="0"></iframe>
    <?php endif; ?>
</body>

</html>
<?php wp_footer(); ?>