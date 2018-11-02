<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$post_id = $_POST['post_id'];
$content_post = get_post($post_id);
$content = $content_post->post_content;

$views = get_metadata("post", $post_id, 'views', 1);
update_post_meta( $post_id, "views", $views + 1 );
?>

<div style="width:100%;" data-id="<?=$post_id?>" class="news_item column">
    <div class="row">
        <h1 align="center">Просмотр новости<span class="close">Закрыть</span></h1>
    </div><br><br>
    <div class="modal-img wrap_img">
        <?php echo get_the_post_thumbnail($post_id); ?>
    </div>
    <div class="wrap_text" style="width:100%;">
        <strong>
            <?php echo get_the_title($post_id);?>
        </strong>
        <p>
            <?php echo $content;?>
        </p>
    </div>
</div>